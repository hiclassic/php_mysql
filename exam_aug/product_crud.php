<?php
include 'config.php';
 include 'navbar.php';

// Insert product
if (isset($_POST['submit_product'])) {
    $name = $_POST['name'];
    $price = intval($_POST['price']);
    $mid = intval($_POST['manufacturer_id']);

    $stmt = $conn->prepare("CALL insert_product(?, ?, ?)");
    $stmt->bind_param("sii", $name, $price, $mid);
    $stmt->execute();
    $stmt->close();
    $conn->next_result();
    $msg = "✅ Product Added!";
}

// Delete manufacturer + trigger will delete products
if (isset($_POST['delete_manufacturer_id'])) {
    $mid = intval($_POST['delete_manufacturer_id']);
    $stmt = $conn->prepare("CALL delete_manufacturer_by_id(?)");
    $stmt->bind_param("i", $mid);
    $stmt->execute();
    $stmt->close();
    $conn->next_result();
    $msg = "⚠️ Manufacturer and its products deleted!";
}

// Get manufacturers for dropdown
$manuf_result = $conn->query("CALL get_all_manufacturers()");

$prod_result = null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="p-5">
<div class="container">
    <h2>Product Management</h2>

    <?php if (isset($msg)) echo "<div class='alert alert-info'>$msg</div>"; ?>

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
                        <?php while ($m = $manuf_result->fetch_assoc()): ?>
                            <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <?php
                $manuf_result->close();
                $conn->next_result();
                ?>
                <button name="submit_product" class="btn btn-primary">Add Product</button>
            </form>

            <hr>

            <h5>Delete Manufacturer</h5>
            <form method="POST" onsubmit="return confirm('Delete manufacturer and all its products?');">
                <div class="mb-3">
                    <?php
                    $manuf_for_del = $conn->query("CALL get_all_manufacturers()");
                    ?>
                    <select name="delete_manufacturer_id" class="form-select" required>
                        <option value="">Select Manufacturer to Delete</option>
                        <?php while ($md = $manuf_for_del->fetch_assoc()): ?>
                            <option value="<?= $md['id'] ?>"><?= htmlspecialchars($md['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                    <?php
                    $manuf_for_del->close();
                    $conn->next_result();
                    ?>
                </div>
                <button type="submit" class="btn btn-danger">Delete Manufacturer</button>
            </form>
        </div>

        <div class="col-md-7">
            <?php
            $prod_result = $conn->query("CALL get_all_products()");
            ?>
            <h4>Products List</h4>
            <table class="table table-bordered">
                <thead>
                    <tr><th>ID</th><th>Name</th><th>Price</th><th>Manufacturer</th></tr>
                </thead>
                <tbody>
                    <?php while ($p = $prod_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td><?= $p['price'] ?></td>
                        <td><?= htmlspecialchars($p['manufacturer_name']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php
            $prod_result->close();
            $conn->next_result();
            ?>
        </div>
    </div>
</div>
</body>
</html>
