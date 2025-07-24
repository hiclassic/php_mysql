<?php
$host = 'localhost';
$db   = 'mydb';
$user = 'root';
$pass = '';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "SELECT * FROM ExpensiveProducts";
  $stmt = $pdo->query($sql);

  echo "<h2>Expensive Products (Price > 5000)</h2>";
  echo "<table border='1' cellpadding='10'>";
  echo "<tr><th>ID</th><th>Name</th><th>Price</th><th>Manufacturer ID</th></tr>";

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>".htmlspecialchars($row['id'])."</td>";
    echo "<td>".htmlspecialchars($row['name'])."</td>";
    echo "<td>".htmlspecialchars($row['price'])."</td>";
    echo "<td>".htmlspecialchars($row['manufacturer_id'])."</td>";
    echo "</tr>";
  }

  echo "</table>";

} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>
