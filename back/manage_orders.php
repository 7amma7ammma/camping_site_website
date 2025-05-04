<?php
require_once 'db.php'; // Adjust path if needed

// Handle status update
if (isset($_GET['complete'])) {
    $order_id = (int)$_GET['complete'];
    $stmt = $conn->prepare("UPDATE orders SET payment_status = 'completed' WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    header("Location: manage_orders.php");
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $order_id = (int)$_GET['delete'];

    // Delete from order_items first due to FK constraint
    $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    // Then delete from orders
    $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    header("Location: manage_orders.php");
    exit;
}

// Fetch orders
$result = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");
$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            background: #fff;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 16px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-complete {
            background-color: #28a745;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-complete:hover {
            background-color: #218838;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<h2>Order Management</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Email</th>
            <th>Total (€)</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($orders) > 0): ?>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['order_id']) ?></td>
                    <td><?= htmlspecialchars($order['customer_name']) ?></td>
                    <td><?= htmlspecialchars($order['customer_email']) ?></td>
                    <td><?= number_format($order['order_total'], 2) ?></td>
                    <td><?= htmlspecialchars($order['payment_status']) ?></td>
                    <td><?= htmlspecialchars($order['order_date']) ?></td>
                    <td>
                        <?php if ($order['payment_status'] !== 'completed'): ?>
                            <a class="btn btn-complete" href="?complete=<?= $order['order_id'] ?>">Mark Completed</a>
                        <?php endif; ?>
                        <a class="btn btn-delete" href="?delete=<?= $order['order_id'] ?>" onclick="return confirm('Delete this order?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7">No orders found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
