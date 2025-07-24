<?php
$host = 'localhost';
$db   = 'mydb';  // তোমার ডাটাবেসের নাম
$user = 'root';
$pass = '';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact_no = $_POST['contact_no'];

    $stmt = $pdo->prepare("CALL insert_manufacturer(:name, :address, :contact_no)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':contact_no', $contact_no);

    $stmt->execute();
    echo "✅ Manufacturer Inserted Successfully!";
  }

} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>
