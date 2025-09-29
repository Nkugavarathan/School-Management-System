<?php
include("../config.php");
// session_start();

// Restrict access
$role = strtolower($_SESSION['role']);
if ($role != 'admin' && $role != 'teacher') {
    die("<div class='alert alert-danger text-center mt-5'>Access Denied</div>");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title       = $_POST['title'];
    $desc        = $_POST['description'];
    $uploaded_by = $_SESSION['user_id'];

    $file = $_FILES['file']['name'];
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // create if not exist
    }

    $target_file = $target_dir . time() . "_" . basename($file);
    $file_type   = (strpos($_FILES['file']['type'], "video") !== false) ? "video" : "image";

    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO media (title, description, file_path, file_type, uploaded_by) 
                VALUES ('$title', '$desc', '$target_file', '$file_type', '$uploaded_by')";
        if ($conn->query($sql)) {
            echo "<script>
                alert('Media uploaded successfully!');
                window.location.href = '../dashboard.php';
            </script>";
            exit();
        } else {
            echo "<div class='alert alert-danger text-center mt-3'>Database error: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center mt-3'>File upload failed!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Media Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #98c5ecff !important;
        }
    </style>
</head>

<body class="text-white d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4 bg-light text-dark" style="max-width: 600px; width: 100%;">
        <a href="../dashboard.php" class="btn btn-secondary mb-4">Back to Dashboard</a>

        <h2 class="text-center mb-4">📤 Upload Event Media</h2>

        <form method="post" enctype="multipart/form-data">
            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Media Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter media title" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description (optional)</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Write a short description..."></textarea>
            </div>

            <!-- File Upload -->
            <div class="mb-3">
                <label for="file" class="form-label">Choose File</label>
                <input class="form-control" type="file" id="file" name="file" accept="image/*,video/*" required>
                <small class="text-muted">Supported: Images (jpg, png) / Videos (mp4)</small>
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-cloud-upload"></i> Upload Media
                </button>
            </div>
        </form>
    </div>
</body>

</html>