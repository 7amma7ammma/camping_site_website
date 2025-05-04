<?php
require_once 'db.php';

// Fetch all camping sites from the database
$result = $conn->query("SELECT * FROM place") or die($conn->error);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camping Sites</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet">
</head>
<body>
 

<div class="nav">
    <a href="index.html">🏠 Home Page</a>
    <a href="about_us.html">About Us</a>
    <a href="produit.php">🛒 Buy Products</a>
    <a href="reservation.php">🏕️ Reserve a Camp</a>
    <div class="profile-dropdown">
        <button class="profile-btn">👤 Profile</button>
        <div class="dropdown-content">
            <a href="profile.php">View Profile</a>
            <a href="index.html">Logout</a>
        </div>
    </div>
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

    .profile-dropdown {
        position: relative;
        display: inline-block;
    }

    .profile-btn {
        background: none;
        border: none;
        color: white;
        font-weight: bold;
        font-size: 18px;
        cursor: pointer;
        padding: 10px 20px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .profile-btn:hover {
        background: rgba(255, 215, 0, 0.8); /* Gold background on hover */
        color: black;
        transform: scale(1.1); /* Slight zoom effect */
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 160px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
        border-radius: 5px;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        font-size: 16px;
    }

    .dropdown-content a:hover {
        background-color: rgba(255, 215, 0, 0.8); /* Gold background on hover */
        color: black;
    }

    .profile-dropdown:hover .dropdown-content {
        display: block;
    }
    
</style>

<header>
    <section class="homepage" id="home">
        <div class="content flex">
            <div class="text">
                <h1>Camping Adventures Await</h1>
                <p>Discover breathtaking outdoor sites and reconnect with nature. Enjoy starlit nights, peaceful trails, and cozy campfires.</p>
            </div>
            <a href="#camping-list" class="explore-btn">Explore</a>
        </div>
    </section>
</header>
</header>

    </header>

    <section class="servics" id="camping-list">
        <div class="container">
            <div class="section-title">
                <h2>Camping Sites</h2>
                <p>Find your perfect outdoor escape!</p>
            </div>

            <!-- Search Bar -->
            <div id="search-container">
                <input type="text" id="searchInput" placeholder="Search camping sites...">
            </div>

            <ul id="camping-cards" class="cards flex">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li class="card">
                        <img src="../back/uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                        <h3><?= htmlspecialchars($row['name']) ?></h3>
                        <p><?= htmlspecialchars($row['description']) ?></p>
                        <!-- ⭐ Rating Placeholder -->
                        <div class="rating">
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span style="margin-left: 8px; font-size: 0.9em;">(Rating coming soon)</span>
                            <a href="place_detail.php?id=<?= $row['id'] ?>" class="discover-btn">Discover</a>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </section>

    <script>
        // Smooth Scroll for "Explore" Button
        document.querySelector('.explore-btn').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('#camping-list').scrollIntoView({ behavior: 'smooth' });
        });

        // Search Filtering
        document.getElementById('searchInput').addEventListener('input', function() {
            const search = this.value.toLowerCase();
            document.querySelectorAll('#camping-cards .card').forEach(card => {
                const name = card.querySelector('h3').textContent.toLowerCase();
                const desc = card.querySelector('p').textContent.toLowerCase();
                card.style.display = (name.includes(search) || desc.includes(search)) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
