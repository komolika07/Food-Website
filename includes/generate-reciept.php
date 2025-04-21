<?php
// Set headers to force download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="order_receipt.html"');

$order_id = $_GET['order_id'] ?? 'Unknown';
$total_price = $_GET['total_price'] ?? '0';
$payment_method = $_GET['payment_method'] ?? 'Unknown';
$order_date = $_GET['order_date'] ?? date('Y-m-d');

echo "<html>
<head>
    <title>Order Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { color: #333; }
        .container { border: 1px solid #ddd; padding: 20px; max-width: 500px; }
        .details p { margin: 5px 0; }
    </style>
</head>
<body>
    <div class='container'>
        <h2>Order Receipt</h2>
        <div class='details'>
            <p><strong>Order ID:</strong> $order_id</p>
            <p><strong>Date:</strong> $order_date</p>
            <p><strong>Total Price:</strong> ₹$total_price</p>
            <p><strong>Payment Method:</strong> $payment_method</p>
        </div>
        <p>Thank you for your order!</p>
    </div>
</body>
</html>";
?>
