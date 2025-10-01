<?php
include("../config.php");

$id = $_GET['id'];
$sql = "SELECT * FROM inventory WHERE item_id='$id'";
$result = $conn->query($sql);
$item = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];

    $update = "UPDATE inventory SET name='$name', quantity='$quantity', category='$category' WHERE item_id='$id'";
    if ($conn->query($update)) {
        echo "<script>alert('Item updated successfully!'); window.location='view.php';</script>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #98c5ecff !important;
        }
    </style>
</head>

<body class="container py-5">
    <a href="./view.php" class="btn btn-secondary mb-4">Back to Inventory List</a>

    <h2 class="text-center">Edit Inventory Item</h2>
    <form method="post" class="card p-4 shadow mx-auto" style="max-width:600px;">
        <div class="mb-3">
            <label class="form-label">Item Name</label>
            <input type="text" name="name" class="form-control" value="<?= $item['name'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" name="quantity" class="form-control" value="<?= $item['quantity'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <input type="text" name="category" class="form-control" value="<?= $item['category'] ?>" required>
        </div>
        <button type="submit" class="btn btn-warning w-100">Update Item</button>
    </form>
</body>

</html>