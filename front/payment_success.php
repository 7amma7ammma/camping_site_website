<?php
session_start();
require_once 'db.php';

$cart = $_SESSION['cart'] ?? [];
$total = 0;
foreach ($cart as $item) {
    if (isset($item['price'], $item['quantity'])) {
        $total += $item['price'] * $item['quantity'];
    }
}

$customer_name = $_POST['customer_name'] ?? '';
$customer_email = $_POST['customer_email'] ?? '';

// Insert order into `orders` table
$payment_status = 'completed';  // Payment status should be 'completed' after successful payment
$order_date = date('Y-m-d H:i:s');

$stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_email, order_total, payment_status, order_date) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssdss", $customer_name, $customer_email, $total, $payment_status, $order_date);
$stmt->execute();
$order_id = $stmt->insert_id;  // Get the order ID after insert
$stmt->close();

// Insert each product into `order_items`
foreach ($cart as $item) {
    $product_id = $item['id'];  // Use 'id' here, which corresponds to 'product_id' in your `order_items` table
    $quantity = $item['quantity'];
    $price = $item['price'];

    if ($product_id > 0) {
        $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt_item->bind_param("iiid", $order_id, $product_id, $quantity, $price);
        $stmt_item->execute();
        $stmt_item->close();
    }
}

// Clear cart after successful payment
$_SESSION['cart'] = [];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .success-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 {
            color: #28a745;
        }
        p {
            font-size: 16px;
            color: #555;
        }
        a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="success-container">
    <h2>Payment Successful!</h2>
    <p>Thank you <strong><?= htmlspecialchars($customer_name) ?></strong> for your purchase of €<?= number_format($total, 2) ?>.</p>
    <p>Your order has been recorded and a receipt will be sent to <strong><?= htmlspecialchars($customer_email) ?></strong>.</p>
    <p><a href="produit.php">Back to Products</a></p>
</div>
</body>
</html>
