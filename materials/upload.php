<?php
include("../config.php");
// session_start();/

// Role check
$role = strtolower($_SESSION['role'] ?? '');
if (!in_array($role, ['teacher', 'admin'])) {
    die("<div class='alert alert-danger text-center mt-5'>Access Denied</div>");
}

// Assign teacher_id only for teachers
$teacher_id = null;
if ($role === 'teacher') {
    $teacher_id = $_SESSION['teacher_id'] ?? null;
    if (!$teacher_id) {
        die("<div class='alert alert-danger text-center'>Error: teacher_id missing in session</div>");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $desc  = $conn->real_escape_string($_POST['description']);

    // Handle file upload
    $file = $_FILES['file']['name'];
    $target_dir = __DIR__ . "/uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $filename = time() . "_" . basename($file);
    $target_file = $target_dir . $filename;
    $relative_path = "uploads/" . $filename;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO materials (teacher_id, title, description, file_path, upload_date) 
                VALUES (" . ($teacher_id ? "'$teacher_id'" : "NULL") . ", '$title', '$desc', '$relative_path', NOW())";

        if ($conn->query($sql)) {
            echo "<div class='alert alert-success text-center mt-3'>📁 File uploaded successfully!</div>";
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
    <title>Upload Study Material</title>
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

        <h2 class="text-center mb-4">📚 Upload Study Material</h2>

        <form method="post" enctype="multipart/form-data">
            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Material Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description (optional)</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>

            <!-- File Upload -->
            <div class="mb-3">
                <label for="file" class="form-label">Select File</label>
                <input class="form-control" type="file" id="file" name="file" required>
                <small class="text-muted">Supported: PDF, DOCX, PPTX, etc.</small>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Upload Material</button>
            </div>
        </form>
    </div>
</body>

</html>