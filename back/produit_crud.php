<!-- filepath: c:\xampp\htdocs\khimaTrip\back\produit_crud.php -->
<?php
include 'db.php';

// CREATE: Add new product
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $review = $_POST['review'];
    $stock_quantity = $_POST['stock_quantity'];
    $price = $_POST['price'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    // Move uploaded image
    move_uploaded_file($tmp, "uploads 2/$image");

    // Insert into product table
    $conn->query("INSERT INTO product (name, category, description, review, stock_quantity, price, image_path)
                  VALUES ('$name', '$category', '$description', '$review', $stock_quantity, $price, '$image')")
        or die($conn->error);

    header("Location: produit_crud.php");
    exit();
}

// UPDATE: Update existing product
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $review = $_POST['review'];
    $stock_quantity = $_POST['stock_quantity'];
    $price = $_POST['price'];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "uploads 2/$image");

        $conn->query("UPDATE product SET name='$name', category='$category', description='$description', review='$review',
                      stock_quantity=$stock_quantity, price=$price, image_path='$image' WHERE id=$id")
            or die($conn->error);
    } else {
        $conn->query("UPDATE product SET name='$name', category='$category', description='$description', review='$review',
                      stock_quantity=$stock_quantity, price=$price WHERE id=$id")
            or die($conn->error);
    }

    header("Location: produit_crud.php");
    exit();
}

// DELETE: Delete product
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM product WHERE id=$id") or die($conn->error);
    header("Location: produit_crud.php");
    exit();
}

// READ: Get all products
$result = $conn->query("SELECT * FROM product") or die($conn->error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Management - KhimaTrip</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal p-10">
  <h1 class="text-3xl font-bold text-gray-800 mb-6">Product Management</h1>
  <a href="produit_form.html" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-6 inline-block">
    + Add New Product
  </a>

  <div class="overflow-x-auto bg-white shadow-md rounded-lg">
    <table class="min-w-full bg-white border border-gray-200">
      <thead>
        <tr class="bg-gray-800 text-white">
          <th class="py-3 px-6 text-left">ID</th>
          <th class="py-3 px-6 text-left">Name</th>
          <th class="py-3 px-6 text-left">Category</th>
          <th class="py-3 px-6 text-left">Description</th>
          <th class="py-3 px-6 text-left">Review</th>
          <th class="py-3 px-6 text-left">Stock</th>
          <th class="py-3 px-6 text-left">Price (€)</th>
          <th class="py-3 px-6 text-left">Image</th>
          <th class="py-3 px-6 text-left">Status</th>
          <th class="py-3 px-6 text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr class="border-b hover:bg-gray-100">
            <td class="py-3 px-6"><?= $row['id'] ?></td>
            <td class="py-3 px-6"><?= htmlspecialchars($row['name']) ?></td>
            <td class="py-3 px-6"><?= htmlspecialchars($row['category']) ?></td>
            <td class="py-3 px-6"><?= htmlspecialchars($row['description']) ?></td>
            <td class="py-3 px-6"><?= htmlspecialchars($row['review']) ?></td>
            <td class="py-3 px-6"><?= htmlspecialchars($row['stock_quantity']) ?></td>
            <td class="py-3 px-6"><?= number_format($row['price'], 2) ?> €</td>
            <td class="py-3 px-6">
              <img src="uploads 2/<?= htmlspecialchars($row['image_path']) ?>" alt="Product Image" class="w-16 h-16 object-cover rounded">
            </td>
            <td class="py-3 px-6">
              <?= ($row['stock_quantity'] > 0) ? '<span class="text-green-500 font-bold">✅ In Stock</span>' : '<span class="text-red-500 font-bold">❌ Out of Stock</span>' ?>
            </td>
            <td class="py-3 px-6">
              <a href="produit_form.html?edit=<?= $row['id'] ?>" class="text-blue-500 hover:underline">Edit</a> |
              <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this product?')" class="text-red-500 hover:underline">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>