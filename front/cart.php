<?php
session_start();

// Remove item
if (isset($_GET['remove'])) {
    $removeId = $_GET['remove'];
    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['id'] == $removeId) {
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index array
            break;
        }
    }
    header("Location: cart.php");
    exit;
}

// Clear all
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link rel="stylesheet" href="style_produit.css">
    <style>
        .cart-container {
            max-width: 800px;
            margin: 100px auto;
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        td:last-child a {
            color: red;
            font-weight: bold;
        }
        .btn-clear {
            background-color: #cc0000;
            color: white;
            border: none;
            padding: 10px 15px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 8px;
        }
        .btn-pay {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            margin-top: 30px;
            cursor: pointer;
            border-radius: 8px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <h2>🛒 Your Shopping Cart</h2>

        <?php if (count($cart) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price (€)</th>
                    <th>Quantity</th>
                    <th>Subtotal (€)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= number_format($item['price'], 2) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= number_format($subtotal, 2) ?></td>
                    <td><a href="?remove=<?= $item['id'] ?>">🗑️</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3 style="text-align: right;">Total: €<?= number_format($total, 2) ?></h3>
        <a href="?clear=true" class="btn-clear">Clear Cart</a>

        <form action="checkout.php" method="post">
            <input type="hidden" name="total" value="<?= $total ?>">
            <button type="submit" class="btn-pay">💳 Pay by Card</button>
        </form>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</body>
</html>
