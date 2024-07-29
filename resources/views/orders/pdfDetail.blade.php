<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        h1, h3, h4 {
            margin: 0;
        }
        .customer-info, .order-info {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Order Details</h1>
    <div class="customer-info">
        <h3>Customer: {{ $order->customer->name }}</h3>
        <h4>Order Date: {{ $order->created_at }}</h4>
        
    </div>
    <div class="order-info">
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->price * $item->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h4>Total Amount: {{ $order->items->sum(fn($item) => $item->price * $item->quantity) }}</h4>
        <h4>Received Amount: {{ $order->payments->sum('amount') }}</h4>
    </div>
</body>
</html>
