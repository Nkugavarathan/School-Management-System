<?php
include("../config.php");

$id = $_GET['id'];

if ($conn->query("DELETE FROM inventory WHERE item_id='$id'")) {
    // Redirect with success flag
    header("Location: view.php?deleted=1");
    exit();
} else {
    // Redirect with error flag
    header("Location: view.php?deleted=0");
    exit();
}
