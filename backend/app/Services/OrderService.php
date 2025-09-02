<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Table;
use App\Models\Food;
use App\Models\OrderItem;
use App\Http\Resources\OrderResource;
use App\Utils\ResponseHelper;
use App\Utils\OrderNumberGenerator;
use App\Enums\OrderStatus;
use App\Enums\TableStatus;
use App\Http\Resources\OrderItemResource;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function getAllOrders()
    {
        $orders = Order::with(['table', 'waiter', 'cashier', 'orderItems.food'])
            ->orderBy('created_at', 'desc')
            ->get();

        return ResponseHelper::success(OrderResource::collection($orders));
    }

    public function getOrdersByStatus(string $status)
    {
        try {
            $status = constant(OrderStatus::class . '::' . strtoupper($status));

            $orders = Order::with(['table', 'waiter', 'cashier', 'orderItems.food'])
                ->where('status', $status)
                ->orderBy('created_at', 'desc')
                ->get();

            return ResponseHelper::success(OrderResource::collection($orders));
        } catch (\InvalidArgumentException $e) {
            return ResponseHelper::error('Invalid status', 400);
        }
    }

    public function openOrder(int $tableId, int $waiterId)
    {
        $table = Table::find($tableId);

        if (!$table) {
            return ResponseHelper::error('Table not found', 404);
        }

        if ($table->status === TableStatus::OCCUPIED) {
            return ResponseHelper::error('Table is already occupied', 400);
        }

        $existingOrder = Order::where('table_id', $tableId)
            ->where('status', OrderStatus::OPEN)
            ->first();

        if ($existingOrder) {
            return ResponseHelper::error('Table already has an open order', 400);
        }

        try {
            DB::beginTransaction();

            $order = Order::create([
                'order_number' => OrderNumberGenerator::generate(),
                'table_id' => $tableId,
                'waiter_id' => $waiterId,
                'status' => OrderStatus::OPEN,
                'opened_at' => now(),
            ]);

            $table->update(['status' => TableStatus::OCCUPIED]);

            DB::commit();

            $order->load(['table', 'waiter']);

            return ResponseHelper::success(new OrderResource($order), 'Order opened successfully', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::error('Failed to open order: ' . $e->getMessage(), 500);
        }
    }

    public function getOrderDetails(int $orderId)
    {
        $order = Order::with(['table', 'waiter', 'cashier', 'orderItems.food'])->find($orderId);

        if (!$order) {
            return ResponseHelper::error('Order not found', 404);
        }

        return ResponseHelper::success(new OrderResource($order));
    }

    public function addOrderItem(int $orderId, array $itemData)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return ResponseHelper::error('Order not found', 404);
        }

        if ($order->status !== OrderStatus::OPEN) {
            return ResponseHelper::error('Cannot add items to closed order', 400);
        }

        $food = Food::find($itemData['food_id']);

        if (!$food) {
            return ResponseHelper::error('Food not found', 404);
        }

        if (!$food->is_available) {
            return ResponseHelper::error('Food is not available', 400);
        }

        try {
            DB::beginTransaction();

            $existingItem = OrderItem::where('order_id', $orderId)
                ->where('food_id', $itemData['food_id'])
                ->first();

            if ($existingItem) {
                $existingItem->quantity += $itemData['quantity'];
                $existingItem->subtotal = $existingItem->quantity * $existingItem->unit_price;
                $existingItem->notes = $itemData['notes'] ?? $existingItem->notes;
                $existingItem->save();

                $orderItem = $existingItem;
            } else {
                $subtotal = $food->price * $itemData['quantity'];

                $orderItem = OrderItem::create([
                    'order_id' => $orderId,
                    'food_id' => $itemData['food_id'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $food->price,
                    'subtotal' => $subtotal,
                    'notes' => $itemData['notes'] ?? null,
                ]);
            }

            $this->updateOrderTotal($order);

            DB::commit();

            $orderItem->load('food');

            return ResponseHelper::success(new OrderItemResource($orderItem), 'Item added to order successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::error('Failed to add item: ' . $e->getMessage(), 500);
        }
    }

    public function closeOrder(int $orderId, int $cashierId)
    {
        $order = Order::with('table')->find($orderId);

        if (!$order) {
            return ResponseHelper::error('Order not found', 404);
        }

        if ($order->status !== OrderStatus::OPEN) {
            return ResponseHelper::error('Order is already closed', 400);
        }

        try {
            DB::beginTransaction();

            $order->update([
                'status' => OrderStatus::CLOSED,
                'cashier_id' => $cashierId,
                'closed_at' => now(),
            ]);

            $order->table->update(['status' => TableStatus::AVAILABLE]);

            DB::commit();

            $order->load(['table', 'waiter', 'cashier', 'orderItems.food']);

            return ResponseHelper::success(new OrderResource($order), 'Order closed successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::error('Failed to close order: ' . $e->getMessage(), 500);
        }
    }

    private function updateOrderTotal(Order $order): void
    {
        $total = $order->orderItems()->sum('subtotal');
        $order->update(['total_amount' => $total]);
    }
}
