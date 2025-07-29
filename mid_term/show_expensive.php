<?php
$pdo = new PDO("mysql:host=localhost;dbname=exm_db", 'root', '2997');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Expensive View Load
$sql = "SELECT * FROM ExpensiveProducts";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Delete Manufacturer if id passed
if (isset($_GET['delete_manufacturer_id'])) {
  $mid = $_GET['delete_manufacturer_id'];

  // Delete manufacturer
  $delStmt = $pdo->prepare("DELETE FROM Manufacturer WHERE id = :mid");
  $delStmt->bindParam(':mid', $mid);
  $delStmt->execute();

  echo "<div class='alert alert-danger'>Manufacturer ID $mid Deleted! Related products removed by trigger.</div>";
  // Reload data
  $stmt = $pdo->query($sql);
  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Show Expensive Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

  <!-- Navbar -->
  <?php include 'navbar.php'; ?>

  <h2>Expensive Products (Price > 5000)</h2>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Product Name</th>
        <th>Price</th>
        <th>Manufacturer ID</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $p): ?>
      <tr>
        <td><?= $p['id'] ?></td>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td><?= $p['price'] ?></td>
        <td><?= $p['manufacturer_id'] ?></td>
        <td>
          <a href="show_expensive.php?delete_manufacturer_id=<?= $p['manufacturer_id'] ?>" 
             onclick="return confirm('Are you sure you want to delete this Manufacturer? All linked products will be deleted!')"
             class="btn btn-danger btn-sm">Delete Manufacturer</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</body>
</html>
