<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Receipt - {{ $order->order_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .restaurant-name {
            font-size: 18px;
            font-weight: bold;
        }

        .order-info {
            margin-bottom: 20px;
        }

        .order-info table {
            width: 100%;
        }

        .order-info td {
            padding: 3px 0;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .items-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .total-section {
            border-top: 2px solid #000;
            padding-top: 10px;
            margin-top: 20px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 14px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="restaurant-name">RESTAURANT POS</div>
        <div>Jl. sendiri saja -_-, Kota Tangerang</div>
        <div>Telp: (021) 12345678</div>
    </div>

    <div class="order-info">
        <table>
            <tr>
                <td><strong>Order Number:</strong></td>
                <td>{{ $order->order_number }}</td>
            </tr>
            <tr>
                <td><strong>Table:</strong></td>
                <td>{{ $order->table->table_number }}</td>
            </tr>
            <tr>
                <td><strong>Waiter:</strong></td>
                <td>{{ $order->waiter->name }}</td>
            </tr>
            <tr>
                <td><strong>Cashier:</strong></td>
                <td>{{ $order->cashier->name ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Date:</strong></td>
                <td>{{ $order->created_at->format('d/m/Y H:i:s') }}</td>
            </tr>
        </table>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>
                        {{ $item->food->name }}
                        @if ($item->notes)
                            <br><small><em>{{ $item->notes }}</em></small>
                        @endif
                    </td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <span>TOTAL:</span>
            <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="footer">
        <p>Thank you for your visit!</p>
        <p><small>{{ now()->format('d/m/Y H:i:s') }}</small></p>
    </div>
</body>

</html>
