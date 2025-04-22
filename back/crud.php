<!-- filepath: c:\xampp\htdocs\khimaTrip\back\crud.php -->
<?php
include 'db.php';

// CREATE: Add new place
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    // Move the uploaded image to the 'uploads' directory
    move_uploaded_file($tmp, "uploads/$image");

    // Insert the place details into the database
    $conn->query("INSERT INTO place (name, description, image) VALUES ('$name', '$description', '$image')")
        or die($conn->error);

    header("Location: crud.php");  // Redirect to the CRUD list page after saving
    exit();
}

// UPDATE: Update existing place
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "uploads/$image");

        // Update the record with a new image
        $conn->query("UPDATE place SET name='$name', description='$description', image='$image' WHERE id=$id")
            or die($conn->error);
    } else {
        // Update without changing the image
        $conn->query("UPDATE place SET name='$name', description='$description' WHERE id=$id")
            or die($conn->error);
    }

    header("Location: crud.php");  // Redirect to CRUD list page
    exit();
}

// DELETE: Delete place from the database
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM place WHERE id=$id") or die($conn->error);
    header("Location: crud.php");  // Redirect after deletion
    exit();
}

// READ: Get all places for display
$result = $conn->query("SELECT * FROM place") or die($conn->error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Places Management - KhimaTrip</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal p-10">
  <h1 class="text-3xl font-bold text-gray-800 mb-6">Places Management</h1>
  <a href="backoffice_form.html" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-6 inline-block">
    + Add New Place
  </a>

  <div class="overflow-x-auto bg-white shadow-md rounded-lg">
    <table class="min-w-full bg-white border border-gray-200">
      <thead>
        <tr class="bg-gray-800 text-white">
          <th class="py-3 px-6 text-left">ID</th>
          <th class="py-3 px-6 text-left">Name</th>
          <th class="py-3 px-6 text-left">Description</th>
          <th class="py-3 px-6 text-left">Image</th>
          <th class="py-3 px-6 text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr class="border-b hover:bg-gray-100">
            <td class="py-3 px-6"><?= $row['id'] ?></td>
            <td class="py-3 px-6"><?= htmlspecialchars($row['name']) ?></td>
            <td class="py-3 px-6"><?= htmlspecialchars($row['description']) ?></td>
            <td class="py-3 px-6">
              <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="Place Image" class="w-16 h-16 object-cover rounded">
            </td>
            <td class="py-3 px-6">
              <a href="backoffice_form.html?edit=<?= $row['id'] ?>" class="text-blue-500 hover:underline">Edit</a> |
              <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this place?')" class="text-red-500 hover:underline">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html> 