<?php

namespace App\Services;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Utils\ResponseHelper;

class ReceiptService
{
    public function generateReceipt(int $orderId)
    {
        $order = Order::with(['table', 'waiter', 'cashier', 'orderItems.food'])->find($orderId);

        if (!$order) {
            return ResponseHelper::error('Order not found', 404);
        }

        try {
            $pdf = Pdf::loadView('receipt', compact('order'));
            $filename = 'receipt-' . $order->order_number . '.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            return ResponseHelper::error('Failed to generate receipt: ' . $e->getMessage(), 500);
        }
    }
}
