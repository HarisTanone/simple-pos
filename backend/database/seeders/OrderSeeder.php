<?php

namespace Database\Seeders;

use App\Enums\OrderStatus;
use App\Enums\TableStatus;
use App\Enums\UserRole;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $pelayan = User::where('role', UserRole::PELAYAN)->first();
        $kasir = User::where('role', UserRole::KASIR)->first();

        $tables = Table::take(3)->get();

        foreach ($tables as $index => $table) {
            $order = Order::create([
                'table_id' => $table->id,
                'waiter_id' => $pelayan->id,
                'cashier_id' => $index > 0 ? $kasir->id : null,
                'status' => $index > 0 ? OrderStatus::CLOSED : OrderStatus::OPEN,
                'opened_at' => now()->subHours(rand(1, 5)),
                'closed_at' => $index > 0 ? now()->subHours(rand(0, 1)) : null,
            ]);

            $table->update([
                'status' => $index > 0 ? TableStatus::AVAILABLE : TableStatus::OCCUPIED
            ]);

            $foods = Food::inRandomOrder()->take(rand(2, 5))->get();
            $totalAmount = 0;

            foreach ($foods as $food) {
                $quantity = rand(1, 3);
                $subtotal = $food->price * $quantity;
                $totalAmount += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'food_id' => $food->id,
                    'quantity' => $quantity,
                    'unit_price' => $food->price,
                    'subtotal' => $subtotal,
                    'notes' => rand(0, 1) ? 'Pedas sedang' : null,
                ]);
            }

            $order->update(['total_amount' => $totalAmount]);
        }
    }
}
