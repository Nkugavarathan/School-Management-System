<?php
include("../config.php");
// session_start();

$sql = "SELECT m.*, t.name as teacher_name 
        FROM materials m 
        JOIN teachers t ON m.teacher_id = t.teacher_id 
        ORDER BY upload_date DESC";
$res = $conn->query($sql);
?>

<h2>Study Materials</h2>
<table border="1">
    <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Uploaded By</th>
        <th>Date</th>
        <th>Download</th>
    </tr>
    <?php while ($row = $res->fetch_assoc()): ?>
        <tr>
            <td><?= $row['title'] ?></td>
            <td><?= $row['description'] ?></td>
            <td><?= $row['teacher_name'] ?></td>
            <td><?= $row['upload_date'] ?></td>
            <td><a href="<?= $row['file_path'] ?>" download>Download</a></td>
        </tr>
    <?php endwhile; ?>
</table>