<?php
include("../config.php");

$id = $_GET['id'];
$conn->query("DELETE FROM inventory WHERE item_id='$id'");
echo "<script>alert('Item deleted successfully!'); window.location='view.php';</script>";
