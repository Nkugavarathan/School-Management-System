<?php
include("../config.php");

if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'teacher') {
    die("Access denied!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];

    $sql = "INSERT INTO inventory (name, quantity, category) VALUES ('$name', '$quantity', '$category')";
    if ($conn->query($sql)) {
        echo "<script>alert('Item added successfully!'); window.location='view.php';</script>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #98c5ecff !important;
        }
    </style>
</head>

<body class="container py-5">
    <a href="../dashboard.php" class="btn btn-secondary mb-4">Back to Dashboard</a>

    <h2 class="text-center">Add Inventory Item</h2>
    <form method="post" class="card p-4 shadow mx-auto" style="max-width:600px;">
        <div class="mb-3">
            <label class="form-label">Item Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <input type="text" name="category" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Add Item</button>
    </form>
</body>

</html>