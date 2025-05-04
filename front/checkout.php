<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
$total = 0;

foreach ($cart as $item) {
    if (isset($item['price'], $item['quantity'])) {
        $total += $item['price'] * $item['quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Payment</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .checkout-container {
            background-color: #fff;
            padding: 40px;
            width: 100%;
            max-width: 480px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="submit"] {
            width: 100%;
            padding: 14px;
            margin-bottom: 15px;
            border-radius: 10px;
            border: 2px solid #ddd;
            font-size: 16px;
            background-color: #f7f7f7;
            transition: 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus {
            border-color: #007bff;
            background-color: #fff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<div class="checkout-container">
    <h2>Card Payment</h2>
    <p>Total to pay: €<?= number_format($total, 2) ?></p>

    <form action="payment_success.php" method="post">
        <input type="text" name="customer_name" placeholder="Your Name" required>
        <input type="email" name="customer_email" placeholder="Your Email" required>
        <input type="text" name="card_number" placeholder="Card Number" required>
        <input type="text" name="card_name" placeholder="Name on Card" required>
        <input type="text" name="expiry" placeholder="MM/YY" required>
        <input type="number" name="cvv" placeholder="CVV" required>
        <input type="submit" value="Pay Now">
    </form>
</div>
</body>
</html>
