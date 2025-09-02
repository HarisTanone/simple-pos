<?php

namespace App\Utils;

use App\Models\Order;

class OrderNumberGenerator
{
    public static function generate(): string
    {
        $date = date('Ymd');
        $todayOrderCount = Order::whereDate('created_at', today())->count() + 1;

        return 'ORD-' . $date . '-' . str_pad($todayOrderCount, 4, '0', STR_PAD_LEFT);
    }
}
