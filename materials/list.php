<?php
include("../config.php");
// session_start();

$sql = "SELECT m.*, t.name as teacher_name 
        FROM materials m 
        JOIN teachers t ON m.teacher_id = t.teacher_id 
        ORDER BY upload_date DESC";
$res = $conn->query($sql);
?>
<html>

<head>
    <title>Material list</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>

    <h2>Study Materials</h2>
    <a href="../dashboard.php" class="btn btn-secondary mb-4">Back to Dashboard</a>
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
</body>

</html>