<!-- filepath: c:\xampp\htdocs\khimaTrip\front\profile.php -->
<?php
require_once 'db.php';

// Fetch user details (replace with actual user ID or session-based user identification)
$userId = 1; // Example user ID
$result = $conn->query("SELECT * FROM users WHERE id = $userId") or die($conn->error);
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

<!-- Navbar -->
<div class="nav">
    <a href="index.html">Home</a>
    <a href="about_us.html">About Us</a>
    <a href="produit.php">Buy Products</a>
    <a href="reservation.php">Reserve a Camp</a>
    <a href="index.html" class="logout-btn">Logout</a>
</div>
<style>
    .nav {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(50, 50, 50, 0.8));
        padding: 20px 0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: space-around;
        align-items: center;
        z-index: 1000;
        border-bottom: 5px solid rgba(255, 215, 0, 0.5); /* Gold border */
    }

    .nav a {
        color: white;
        text-decoration: none;
        font-weight: bold;
        font-size: 18px;
        padding: 10px 20px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .nav a:hover {
        background: rgba(255, 215, 0, 0.8); /* Gold background on hover */
        color: black;
        transform: scale(1.1); /* Slight zoom effect */
    }

    .logout-btn {
        background: rgba(255, 0, 0, 0.8);
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .logout-btn:hover {
        background: rgba(255, 0, 0, 1);
        transform: scale(1.1);
    }
</style>

<!-- Profile Section -->
<section class="profile-section mt-20">
    <div class="container mx-auto px-4">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">My Profile</h1>
            <div class="profile-details">
                <p><strong>Name:</strong> <?= htmlspecialchars($user['username']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                <p><strong>Joined On:</strong> <?= htmlspecialchars($user['created_at']) ?></p>
            </div>
       </div>
    </div>
</section>

<style>
    .profile-section {
        margin-top: 100px;
    }

    .profile-details p {
        font-size: 18px;
        margin-bottom: 10px;
        color: #333;
    }

    .edit-btn {
        display: inline-block;
        margin-top: 20px;
        text-decoration: none;
        font-weight: bold;
    }
</style>

</body>
</html>