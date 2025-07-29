<?php
$pdo = new PDO("mysql:host=localhost;dbname=exm_db", 'root', '2997');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Insert Result</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

  <!-- Navbar -->
  <?php include 'navbar.php'; ?>

  <?php
  if (isset($_POST['submit_manufacturer'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact_no = $_POST['contact_no'];

    $stmt = $pdo->prepare("CALL insert_manufacturer(:name, :address, :contact_no)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':contact_no', $contact_no);
    $stmt->execute();

    echo "<div class='alert alert-success'>Manufacturer Inserted Successfully!</div>";
  }

  if (isset($_POST['submit_product'])) {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $manufacturer_id = $_POST['manufacturer_id'];

    $stmt = $pdo->prepare("INSERT INTO Product (name, price, manufacturer_id) VALUES (:name, :price, :mid)");
    $stmt->bindParam(':name', $product_name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':mid', $manufacturer_id);
    $stmt->execute();

    echo "<div class='alert alert-success'>Product Inserted Successfully!</div>";
  }
  ?>

</body>
</html>
