<?php

include("../config.php");

if (!in_array($_SESSION['role'], ['admin', 'teacher'])) {
    die("Unauthorized access");
}

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM materials WHERE material_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: list.php");
exit();
