<!-- filepath: c:\xampp\htdocs\khimaTrip\back\stats.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Statistics - KhimaTrip</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal p-10">
  <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Statistics</h1>
  <p class="text-gray-600 mb-8">Here are some key statistics about your places and products.</p>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Total Places -->
    <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Total Places</h2>
      <p class="text-gray-600 mb-4">Number of places available for camping trips.</p>
      <div class="text-4xl font-bold text-blue-500">
        <?php
        include 'db.php';
        $result = $conn->query("SELECT COUNT(*) AS total_places FROM place");
        if ($result) {
          $row = $result->fetch_assoc();
          echo htmlspecialchars($row['total_places']);
        } else {
          echo "0";
        }
        ?>
      </div>
    </div>

    <!-- Total Products -->
    <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Total Products</h2>
      <p class="text-gray-600 mb-4">Number of products available in the store.</p>
      <div class="text-4xl font-bold text-green-500">
        <?php
        $result = $conn->query("SELECT COUNT(*) AS total_products FROM product");
        if ($result) {
          $row = $result->fetch_assoc();
          echo htmlspecialchars($row['total_products']);
        } else {
          echo "0";
        }
        ?>
      </div>
    </div>

       <!-- Total orders -->
       <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Total orders</h2>
      <p class="text-gray-600 mb-4">Number of orders requested.</p>
      <div class="text-4xl font-bold text-green-500">
        <?php
        $result = $conn->query("SELECT COUNT(*) AS total_orders FROM orders");
        if ($result) {
          $row = $result->fetch_assoc();
          echo htmlspecialchars($row['total_orders']);
        } else {
          echo "0";
        }
        ?>
      </div>
    </div>

    <!-- Total reservations -->
    <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Total reservations</h2>
      <p class="text-gray-600 mb-4">Number of reservations made.</p>
      <div class="text-4xl font-bold text-green-500">
        <?php
        $result = $conn->query("SELECT COUNT(*) AS total_reservations FROM reservation");
        if ($result) {
          $row = $result->fetch_assoc();
          echo htmlspecialchars($row['total_reservations']);
        } else {
          echo "0";
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>