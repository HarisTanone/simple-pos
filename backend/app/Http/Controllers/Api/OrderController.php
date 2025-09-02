<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OpenOrderRequest;
use App\Http\Requests\Order\AddOrderItemRequest;
use App\Services\OrderService;
use App\Services\ReceiptService;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    protected $orderService;
    protected $receiptService;

    public function __construct(OrderService $orderService, ReceiptService $receiptService)
    {
        $this->orderService = $orderService;
        $this->receiptService = $receiptService;
    }

    public function index()
    {
        return $this->orderService->getAllOrders();
    }

    public function status($status)
    {
        return $this->orderService->getOrdersByStatus($status);
    }

    public function open(OpenOrderRequest $request)
    {
        return $this->orderService->openOrder(
            $request->table_id,
            $request->user()->id
        );
    }

    public function show($id)
    {
        return $this->orderService->getOrderDetails($id);
    }

    public function addItem(AddOrderItemRequest $request, $id)
    {
        return $this->orderService->addOrderItem($id, $request->validated());
    }

    public function close(Request $request, $id)
    {
        return $this->orderService->closeOrder($id, $request->user()->id);
    }

    public function generateReceipt($id)
    {
        return $this->receiptService->generateReceipt($id);
    }
}
