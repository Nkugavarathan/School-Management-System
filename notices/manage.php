<?php
include("../config.php");
// session_start();

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'teacher'])) {
    die("Access denied");
}

$sql = "SELECT a.*, u.username AS posted_by_name 
        FROM announcements a 
        JOIN users u ON a.posted_by = u.user_id 
        ORDER BY post_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Manage Notices</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #98c5ecff !important;
        }
    </style>
</head>

<body class="container p-5">
    <h2>Manage Notices</h2>
    <a href="add.php" class="btn btn-success mb-3">Add New Notice</a>
    <a href="../dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Posted By</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['title'] ?></td>
                        <td><?= $row['posted_by_name'] ?></td>
                        <td><?= $row['post_date'] ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['announcement_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="delete.php?id=<?= $row['announcement_id'] ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="4" class="text-center">No notices found</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>