<?php include("../config.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <title>View Attendance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="container p-5">
    <a href="../dashboard.php" class="btn btn-secondary mb-4">Back to Dashboard</a>
    <h2>Attendance Records</h2>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Student</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        <?php
        $result = $conn->query("SELECT a.*, s.name FROM attendance a JOIN students s ON a.student_id=s.student_id");
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['attendance_id'] . "</td><td>" . $row['name'] . "</td><td>" . $row['date'] . "</td><td>" . $row['status'] . "</td></tr>";
        }
        ?>
    </table>
</body>

</html>