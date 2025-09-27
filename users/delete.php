<?php
include("../config.php");
// session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") die("Access denied");

$id = $_GET['id'];

// Delete from role-specific tables first
$conn->query("DELETE FROM teachers WHERE user_id='$id'");
$conn->query("DELETE FROM students WHERE user_id='$id'");

// Then delete from users
$conn->query("DELETE FROM users WHERE user_id='$id'");

header("Location: manage.php");
exit();
