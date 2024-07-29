<!DOCTYPE html>
<html>
<head>
    <title>Orders Report</title>
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
    <h1>Orders Report</h1>
    <div class="order-info">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Received Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->getCustomerName()}}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>Rp. {{$order->formattedTotal()}}</td>
                        <td>Rp. {{$order->formattedReceivedAmount()}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
