<?php
$pdo = new PDO("mysql:host=localhost;dbname=exm_db", 'root', '2997');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM ExpensiveProducts";
$stmt = $pdo->query($sql);
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
  <?php include '../navbar.php'; ?>

  <h2>Expensive Products (Price > 5000)</h2>
  <table class="table table-bordered">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Price</th>
      <th>Manufacturer ID</th>
    </tr>
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
    <tr>
      <td><?= htmlspecialchars($row['id']) ?></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['price']) ?></td>
      <td><?= htmlspecialchars($row['manufacturer_id']) ?></td>
    </tr>
    <?php endwhile; ?>
  </table>

</body>
</html>
