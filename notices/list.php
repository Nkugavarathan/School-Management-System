<?php
include("../config.php");
// session_start();

$sql = "SELECT a.*, u.username AS posted_by_name 
        FROM announcements a 
        JOIN users u ON a.posted_by = u.user_id
        ORDER BY post_date DESC";

$res = $conn->query($sql);
?>

<head>
    <style>
        body {
            background-color: #98c5ecff !important;
        }
    </style>
</head>

<h2>Notice Board</h2>
<table border="1">
    <tr>
        <th>Title</th>
        <th>Content</th>
        <th>Posted By</th>
        <th>Date</th>
    </tr>
    <?php while ($row = $res->fetch_assoc()): ?>
        <tr>
            <td><?= $row['title'] ?></td>
            <td><?= $row['content'] ?></td>
            <td><?= $row['posted_by_name'] ?></td>
            <td><?= $row['post_date'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>