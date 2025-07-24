<?php
// Database connection
$pdo = new PDO("mysql:host=localhost;dbname=exm_db", 'root', '2997');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Manufacturer লিস্ট নিতে
$stmt = $pdo->query("SELECT id, name FROM Manufacturer");
$manufacturers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Database Driven Web App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

  <!-- Navbar -->
  <?php include '../navbar.php'; ?>

  <!-- ✅ Manufacturer Insert Form -->
  <h2>Add Manufacturer</h2>
  <form method="POST" action="insert.php" class="mb-4">
    <div class="mb-3">
      <label class="form-label">Name:</label>
      <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Address:</label>
      <input type="text" name="address" class="form-control">
    </div>

    <div class="mb-3">
      <label class="form-label">Contact No:</label>
      <input type="text" name="contact_no" class="form-control">
    </div>

    <button type="submit" name="submit_manufacturer" class="btn btn-primary">Insert Manufacturer</button>
  </form>

  <hr>

  <!-- ✅ Product Insert Form -->
  <h2>Add Product</h2>
  <form method="POST" action="insert.php">
    <div class="mb-3">
      <label class="form-label">Product Name:</label>
      <input type="text" name="product_name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Price:</label>
      <input type="number" name="price" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Select Manufacturer:</label>
      <select name="manufacturer_id" class="form-select" required>
        <option value="">--Select--</option>
        <?php foreach ($manufacturers as $m): ?>
          <option value="<?= $m['id'] ?>">
            <?= htmlspecialchars($m['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <button type="submit" name="submit_product" class="btn btn-success">Insert Product</button>
  </form>

</body>
</html>
