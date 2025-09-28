<?php
include("../config.php");
// session_start();

// Only admin allowed
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    die("Access denied");
}

// Fetch all users with student info if applicable
$sql = "SELECT users.*, students.student_id 
        FROM users 
        LEFT JOIN students ON users.user_id = students.user_id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="container p-5">
    <h2>Manage Users</h2>

    <a href="../dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $usernameDisplay = htmlspecialchars($row['username']);
                    if ($row['role'] == 'student' && !empty($row['student_id'])) {
                        $usernameDisplay .= " (student_id=" . htmlspecialchars($row['student_id']) . ")";
                    }
            ?>
                    <tr>
                        <td><?= htmlspecialchars($row['user_id']) ?></td>
                        <td><?= $usernameDisplay ?></td>
                        <td><?= htmlspecialchars($row['role']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['user_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="delete.php?id=<?= $row['user_id'] ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                            <?php if ($row['role'] == 'student') { ?>
                                <a href="../fees/add.php?student_id=<?= $row['student_id'] ?>" class="btn btn-warning btn-sm">Add Fee</a>
                                <a href="../records/add.php?student_id=<?= $row['student_id'] ?>" class="btn btn-secondary btn-sm">Add Record</a>
                                <a href="../attendance/add.php?student_id=<?= $row['student_id'] ?>" class="btn btn-success btn-sm">Add Attendadce</a>

                            <?php } ?>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="4" class="text-center">No users found</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>