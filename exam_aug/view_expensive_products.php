<?php
include 'config.php';
include 'navbar.php';

$result = $conn->query("CALL get_expensive_products()");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Expensive Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="p-5">
<div class="container">
    <h2>Expensive Products (Price &gt; 5000)</h2>

    <?php if ($result && $result->num_rows > 0): ?>
    <table class="table table-bordered">
        <thead>
            <tr><th>ID</th><th>Name</th><th>Price</th><th>Manufacturer</th></tr>
        </thead>
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
    <?php else: ?>
    <div class="alert alert-info">No expensive products found.</div>
    <?php endif; ?>

    <?php
    if ($result) {
        $result->close();
        $conn->next_result();
    }
    ?>
</div>
</body>
</html>
