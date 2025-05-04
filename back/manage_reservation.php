<?php
include 'db.php';

// Delete a reservation if delete parameter is passed
if (isset($_GET['delete'])) {
    $reservation_id = (int) $_GET['delete'];
    $delete_query = "DELETE FROM reservation WHERE reservation_id = $reservation_id";
    $conn->query($delete_query) or die($conn->error);
    header("Location: manage_reservation.php"); // Refresh the page after deletion
    exit();
}

// Fetch all reservations
$query = "
    SELECT reservation_id, name, email, phone, reservation_date, reservation_time, guests, message, created_at
    FROM reservation
    ORDER BY reservation_date DESC, reservation_time DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Réservations</title>
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
    <h2>📋 Gestion des Réservations</h2>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4">#ID</th>
                    <th class="py-3 px-4">Nom</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4">Téléphone</th>
                    <th class="py-3 px-4">Date</th>
                    <th class="py-3 px-4">Heure</th>
                    <th class="py-3 px-4">Invités</th>
                    <th class="py-3 px-4">Message</th>
                    <th class="py-3 px-4">Créé le</th>
                    <th class="py-3 px-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-4"><?= $row['reservation_id'] ?></td>
                        <td class="py-2 px-4"><?= htmlspecialchars($row['name']) ?></td>
                        <td class="py-2 px-4"><?= htmlspecialchars($row['email']) ?></td>
                        <td class="py-2 px-4"><?= htmlspecialchars($row['phone']) ?></td>
                        <td class="py-2 px-4"><?= htmlspecialchars($row['reservation_date']) ?></td>
                        <td class="py-2 px-4"><?= htmlspecialchars($row['reservation_time']) ?></td>
                        <td class="py-2 px-4"><?= htmlspecialchars($row['guests']) ?></td>
                        <td class="py-2 px-4"><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                        <td class="py-2 px-4"><?= $row['created_at'] ?></td>
                        <td class="py-2 px-4">
                            <a href="?delete=<?= $row['reservation_id'] ?>" 
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')"
                               class="btn btn-delete">
                               Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
