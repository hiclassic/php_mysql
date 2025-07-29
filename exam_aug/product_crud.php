<?php
include 'config.php';

// Get manufacturers for dropdown
$manufacturers = $conn->query("SELECT * FROM manufacturer");

// Handle Insert via SP
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = intval($_POST['price']);
    $mid = intval($_POST['manufacturer_id']);

    $stmt = $conn->prepare("CALL insert_product(?, ?, ?)");
    $stmt->bind_param("sii", $name, $price, $mid);
    $stmt->execute();
    $stmt->close();
    $msg = "✅ Product Added!";
}

// Fetch all products with manufacturer name
$sql = "SELECT p.id, p.name, p.price, p.manufacturer_id, m.name AS manufacturer_name
        FROM product p
        LEFT JOIN manufacturer m ON p.manufacturer_id = m.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="p-5">
<div class="container">
    <h2>Product Management</h2>

    <?php if (isset($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>

    <div class="row">
        <div class="col-md-5">
            <h4>Add Product</h4>
            <form method="POST">
                <div class="mb-3">
                    <label>Product Name</label>
                    <input name="name" type="text" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label>Price</label>
                    <input name="price" type="number" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label>Manufacturer</label>
                    <select name="manufacturer_id" class="form-select" required>
                        <option value="">Select Manufacturer</option>
                        <?php while ($m = $manufacturers->fetch_assoc()): ?>
                            <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button name="submit" class="btn btn-primary">Add Product</button>
            </form>
        </div>

        <div class="col-md-7">
            <h4>Products List</h4>
            <table class="table table-bordered">
                <thead><tr>
                    <th>ID</th><th>Name</th><th>Price</th><th>Manufacturer</th>
                </tr></thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= $row['price'] ?></td>
                        <td><?= htmlspecialchars($row['manufacturer_name']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
