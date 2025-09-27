<?php
include("../config.php");
// session_start();

// Only Admin or Teacher can delete
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'teacher'])) {
    die("Access denied");
}

// Get the notice ID from URL
if (!isset($_GET['id'])) die("Notice ID missing");
$id = $_GET['id'];

// Delete from database
$conn->query("DELETE FROM announcements WHERE announcement_id='$id'");

// Redirect back to manage page
header("Location: manage.php");
exit();
