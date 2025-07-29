<?php
include 'config.php';
include 'navbar.php';

// Insert manufacturer
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact = $_POST['contact_no'];

    $stmt = $conn->prepare("CALL insert_manufacturer(?, ?, ?)");
    $stmt->bind_param("sss", $name, $address, $contact);
    $stmt->execute();
    $stmt->close();
    $conn->next_result();
    $msg = "✅ Manufacturer Added!";
}

// Fetch manufacturers
$result = $conn->query("CALL get_all_manufacturers()");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manufacturer Management</title>
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
            <h4>Manufacturer List</h4>
            <table class="table table-bordered">
                <thead><tr><th>ID</th><th>Name</th><th>Address</th><th>Contact</th></tr></thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['address']) ?></td>
                        <td><?= htmlspecialchars($row['contact_no']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php
            $result->close();
            $conn->next_result();
            ?>
        </div>
    </div>
</div>
</body>
</html>

