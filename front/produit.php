<?php
require_once 'db.php';

// Fetch all products from the database
$result = $conn->query("SELECT * FROM product") or die($conn->error);
$categoryResult = $conn->query("SELECT DISTINCT category FROM product") or die($conn->error);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Products</title>
    <link rel="stylesheet" href="style_produit.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
                    <h1>Explore Our Products</h1>
                    <p>Discover our top-quality camping gear and essentials.</p>
                </div>
                
                <a href="#product-list" class="explore-btn">Explore</a>
            </div>
        </section>
    </header>

    <section class="servics" id="product-list">
        <div class="container">
            <div class="section-title">
                <h2>Available Products</h2>
                <p>Everything you need for your next adventure.</p>
            </div>

            <!-- Search Bar -->
            <div id="search-container">
                <input type="text" id="searchInput" placeholder="Search products...">
            </div>

            <ul id="camping-cards" class="cards flex">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li class="card" data-category="<?= htmlspecialchars(strtolower($row['category'])) ?>">

    <img src="../back/uploads 2/<?= htmlspecialchars($row['image_path']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
    <h3><?= htmlspecialchars($row['name']) ?></h3>
    <p><strong>Description:</strong> <?= htmlspecialchars($row['description']) ?></p>
    <p><strong>Category:</strong> <?= htmlspecialchars($row['category']) ?></p>
    <p><strong>Price:</strong> <?= number_format($row['price'], 2) ?> €</p> <!-- NEW LINE -->
    <p><strong>Review:</strong> <?= htmlspecialchars($row['review']) ?></p>
    <p style="color: <?= $row['stock_quantity'] > 0 ? 'green' : 'red' ?>;">
        <strong>Status:</strong> <?= $row['stock_quantity'] > 0 ? 'In Stock' : 'Out of Stock' ?>
    </p>

    <!-- Rating Placeholder -->
    <div class="rating">
        <span class="fa fa-star"></span>
        <span class="fa fa-star"></span>
        <span class="fa fa-star"></span>
        <span class="fa fa-star"></span>
        <span class="fa fa-star"></span>
        <span style="margin-left: 8px; font-size: 0.9em;">(Rating coming soon)</span>
    </div>
</li>

                <?php endwhile; ?>
            </ul>
        </div>
    </section>
    

    <script>
        // Smooth Scroll
        document.querySelector('.explore-btn').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('#product-list').scrollIntoView({ behavior: 'smooth' });
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

    
    
    <div class="category-bar flex">
    <?php while ($cat = $categoryResult->fetch_assoc()): ?>
        <div class="category-card" onclick="filterByCategory('<?= strtolower($cat['category']) ?>')">

            <!--<div class="category-image">
                <img src="../back/uploads 2/<?= strtolower($cat['category']) ?>.jpeg" alt="<?= $cat['category'] ?>">
            </div> -->
            <p><strong><?= strtoupper($cat['category']) ?></strong></p>
        </div>
    <?php endwhile; ?>
</div>
<script>
    function filterByCategory(category) {
        const selected = category.toLowerCase();
        document.querySelectorAll('#camping-cards .card').forEach(card => {
            const cardCategory = card.getAttribute('data-category').toLowerCase();
            card.style.display = (selected === 'all' || cardCategory === selected) ? 'block' : 'none';
        });
    }

    // Optional: Add a way to reset
    const resetButton = document.createElement('button');
    resetButton.innerText = 'Show All';
    resetButton.onclick = () => filterByCategory('all');
    document.querySelector('.category-bar').appendChild(resetButton);


// Add custom styles (you can also use classes instead)
resetButton.style.padding = '12px 30px';
resetButton.style.backgroundColor = '#fff';
resetButton.style.color = '#333';
resetButton.style.border = '2px solid transparent';
resetButton.style.borderRadius = '30px';
resetButton.style.fontSize = '1rem';
resetButton.style.fontWeight = '500';
resetButton.style.cursor = 'pointer';
resetButton.style.transition = 'all 0.4s ease';
resetButton.style.marginTop = '20px';
resetButton.style.display = 'inline-block';
resetButton.style.textAlign = 'center';
resetButton.style.position = 'relative';
resetButton.style.overflow = 'hidden';
resetButton.style.border = 'none'; // Remove default button border

// Shine effect - You can also define this in your CSS
resetButton.style.position = 'relative';
const shineEffect = document.createElement('div');
shineEffect.style.content = '';
shineEffect.style.position = 'absolute';
shineEffect.style.top = '0';
shineEffect.style.left = '-100%';
shineEffect.style.width = '200%';
shineEffect.style.height = '100%';
shineEffect.style.background = 'rgba(255, 255, 255, 0.4)';
shineEffect.style.transform = 'skewX(-20deg)';
shineEffect.style.transition = '0.6s';
shineEffect.style.borderRadius = 'inherit';
resetButton.appendChild(shineEffect);

// Hover effect logic using JavaScript
resetButton.addEventListener('mouseover', () => {
    resetButton.style.backgroundColor = 'rgba(255, 255, 255, 0.2)';
    resetButton.style.color = '#fff';
    resetButton.style.borderColor = '#fff';
    resetButton.style.transform = 'scale(1.05)';
    shineEffect.style.left = '100%';
});

resetButton.addEventListener('mouseout', () => {
    resetButton.style.backgroundColor = '#fff'; // Reset to original background
    resetButton.style.color = '#333'; // Reset to original text color
    resetButton.style.borderColor = 'transparent'; // Reset border
    resetButton.style.transform = 'scale(1)'; // Reset scaling
    shineEffect.style.left = '-100%';
});


</script>
   
</body>
</html>
