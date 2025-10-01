<?php
include("../config.php");

$sql = "SELECT * FROM inventory ORDER BY category, name";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Toastify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <style>
        body {
            background-color: #98c5ecff !important;
        }
    </style>
</head>

<body class="container py-5">
    <a href="../dashboard.php" class="btn btn-secondary mb-4">Back to Dashboard</a>

    <h2>Inventory List</h2>
    <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'teacher') { ?>
        <a href="add.php" class="btn btn-success mb-3">+ Add New Item</a>
    <?php } ?>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Item ID</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Category</th>
                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'teacher') { ?>
                    <th>Actions</th>
                <?php } ?>

            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['item_id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td><?= $row['category'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['item_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete.php?id=<?= $row['item_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>

<script>
    <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
        Toastify({
            text: "🗑️ Item deleted successfully!",
            duration: 4000,
            close: true,
            gravity: "top",
            position: "center",
            backgroundColor: "#dc3545", // red
            stopOnFocus: true
        }).showToast();

        // Clean up URL
        setTimeout(() => {
            history.replaceState(null, "", window.location.pathname);
        }, 4200);
    <?php elseif (isset($_GET['deleted']) && $_GET['deleted'] == 0): ?>
        Toastify({
            text: "❌ Failed to delete item!",
            duration: 4000,
            close: true,
            gravity: "top",
            position: "center",
            backgroundColor: "#6c757d", // gray
            stopOnFocus: true
        }).showToast();

        setTimeout(() => {
            history.replaceState(null, "", window.location.pathname);
        }, 4200);
    <?php endif; ?>
</script>