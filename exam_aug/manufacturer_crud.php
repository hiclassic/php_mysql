<?php
include 'config.php';

// Handle Insert via SP
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact = $_POST['contact_no'];

    $stmt = $conn->prepare("CALL insert_manufacturer(?, ?, ?)");
    $stmt->bind_param("sss", $name, $address, $contact);
    $stmt->execute();
    $stmt->close();
    $msg = "✅ Manufacturer Added!";
}

// Handle Delete via SP
if (isset($_POST['delete_manufacturer_id'])) {
    $mid = intval($_POST['delete_manufacturer_id']);
    $stmt = $conn->prepare("CALL delete_manufacturer_by_id(?)");
    $stmt->bind_param("i", $mid);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch all manufacturers (direct select is okay)
$result = $conn->query("SELECT * FROM manufacturer");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manufacturer CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="p-5">
<div class="container">
    <h2>Manufacturer Management</h2>

    <?php if (isset($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>

    <div class="row">
        <div class="col-md-5">
            <h4>Add Manufacturer</h4>
            <form method="POST">
                <div class="mb-3">
                    <label>Name</label>
                    <input name="name" type="text" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label>Address</label>
                    <input name="address" type="text" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label>Contact No</label>
                    <input name="contact_no" type="text" class="form-control" required />
                </div>
                <button name="submit" class="btn btn-primary">Add Manufacturer</button>
            </form>
        </div>

        <div class="col-md-7">
            <h4>Manufacturers List</h4>
            <table class="table table-bordered">
                <thead><tr><th>ID</th><th>Name</th><th>Address</th><th>Contact</th><th>Delete</th></tr></thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['address']) ?></td>
                        <td><?= htmlspecialchars($row['contact_no']) ?></td>
                        <td>
                            <form method="POST" onsubmit="return confirm('Delete manufacturer and all related products?');">
                                <input type="hidden" name="delete_manufacturer_id" value="<?= $row['id'] ?>" />
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
