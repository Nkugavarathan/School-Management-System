<?php
include("../config.php");

$role = strtolower($_SESSION['role']);
if ($role != 'admin' && $role != 'teacher') {
    die("Access denied");
}

// Make sure teacher_id is set for teachers
$teacher_id = ($_SESSION['role'] == 'teacher') ? ($_SESSION['teacher_id'] ?? 0) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $desc  = $_POST['description'];

    if ($_SESSION['role'] == 'teacher' && empty($_SESSION['teacher_id'])) {
        die("Error: teacher_id not found in session. Please fix login code.");
    }

    $file = $_FILES['file']['name'];
    $target_dir = __DIR__ . "/uploads/";  // absolute path
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);   // create uploads folder if not exists
    }

    $target_file = $target_dir . time() . "_" . basename($file);

    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
        $relative_path = "uploads/" . time() . "_" . basename($file); // save relative path
        $sql = "INSERT INTO materials (teacher_id, title, description, file_path) 
                VALUES ('$teacher_id', '$title', '$desc', '$relative_path')";
        if ($conn->query($sql)) {
            echo "<p style='color:green;'>File uploaded successfully!</p>";
        } else {
            echo "<p style='color:red;'>Database error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:red;'>File upload failed!</p>";
    }
}
?>

<h2>Upload Study Material</h2>
<form method="post" enctype="multipart/form-data">
    <label>Title:</label><input type="text" name="title" required><br>
    <label>Description:</label><textarea name="description"></textarea><br>
    <label>Select File:</label><input type="file" name="file" required><br>
    <button type="submit">Upload</button>
</form>