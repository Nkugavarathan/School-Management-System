<?php
include("../config.php");

if ($_SESSION['role'] != 'admin') {
    die("Access denied!");
}

if (isset($_POST['media_id'])) {
    $media_id = $_POST['media_id'];

    // Fetch file path
    $sql = "SELECT file_path FROM media WHERE media_id='$media_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $file_path = $row['file_path'];

        // Delete from DB
        $conn->query("DELETE FROM media WHERE media_id='$media_id'");

        // Delete file from uploads folder
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        echo "<script>alert('Media deleted successfully!'); window.location='gallery.php';</script>";
    } else {
        echo "<script>alert('Media not found!'); window.location='gallery.php';</script>";
    }
}
