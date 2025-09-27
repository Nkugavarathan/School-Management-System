<?php
include("../config.php");
// session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") die("Access denied");

$id = $_GET['id'];
$conn->query("DELETE FROM users WHERE user_id='$id'");
header("Location: manage.php");
exit();
