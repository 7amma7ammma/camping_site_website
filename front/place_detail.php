<?php
require_once 'db.php';

if (!isset($_GET['id'])) {
    echo "No place selected.";
    exit;
}

$id = (int) $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM place WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Place not found.";
    exit;
}

$place = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($place['name']) ?> | Découverte</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #121212;
            color: white;
            padding: 40px;
        }

        .detail-container {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            justify-content: center;
            gap: 30px;
            max-width: 1400px;
            margin: auto;
        }

        .text-section {
            flex: 1 1 35%;
            min-width: 300px;
        }

        .text-section h1 {
            font-size: 3em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .text-section h3 {
            text-transform: uppercase;
            color: #ccc;
            margin-top: 0;
        }

        .text-section p {
            font-size: 1.1em;
            line-height: 1.6;
            color: #ddd;
        }

        .reserve-btn {
            display: inline-block;
            margin-top: 25px;
            background-color: white;
            color: black;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: bold;
            text-decoration: none;
            transition: background 0.3s;
        }

        .reserve-btn:hover {
            background-color: #ccc;
        }

        .image-section {
            flex: 1 1 60%;
            max-width: 800px;
        }

        .image-section img {
            width: 100%;
            height: auto;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        @media screen and (max-width: 768px) {
            .detail-container {
                flex-direction: column;
                padding: 10px;
            }

            .image-section {
                order: -1;
            }
        }

        /* Gear Section - Horizontal Icons */
        .gear-section {
            margin-top: 60px;
            padding: 40px 20px;
            background-color: #1f1f1f;
            border-radius: 12px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .gear-section h2 {
            font-size: 2em;
            text-align: center;
            margin-bottom: 30px;
            color: #f0f0f0;
        }

        .gear-items {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 40px;
        }

        .gear-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #ddd;
            width: 120px;
            text-align: center;
        }

        .gear-item i {
            font-size: 2.5em;
            margin-bottom: 10px;
            color: #4caf50;
        }

        .gear-item span {
            font-size: 0.95em;
        }
    </style>
</head>
<body>

<div class="detail-container">
    <div class="text-section">
        <h1><?= strtoupper(htmlspecialchars($place['name'])) ?></h1>
        <h3>Randonnée découverte à <?= htmlspecialchars($place['location'] ?? '—') ?></h3>
        <p><?= nl2br(htmlspecialchars($place['description'])) ?></p>
        <a href="booking.html?place_id=<?= $place['id'] ?>" class="reserve-btn">RÉSERVER</a>
    </div>

    <div class="image-section">
        <img src="../back/uploads/<?= htmlspecialchars($place['image']) ?>" alt="Image de la randonnée">
    </div>
</div>

<!-- MATÉRIEL À PRÉVOIR -->
<div class="gear-section">
    <h2>MATÉRIEL À PRÉVOIR</h2>
    <div class="gear-items">
        <div class="gear-item">
            <i class="fas fa-hiking"></i>
            <span>Chaussures</span>
        </div>
        <div class="gear-item">
            <i class="fas fa-hat-cowboy"></i>
            <span>Chapeau</span>
        </div>
        <div class="gear-item">
            <i class="fas fa-sun"></i>
            <span>Crème solaire</span>
        </div>
        <div class="gear-item">
            <i class="fas fa-water"></i>
            <span>Bouteille d'eau</span>
        </div>
        <div class="gear-item">
            <i class="fas fa-apple-alt"></i>
            <span>Collation</span>
        </div>
        <div class="gear-item">
            <i class="fas fa-cloud-sun"></i>
            <span>Vêtements adaptés</span>
        </div>
    </div>
</div>

</body>
</html>
