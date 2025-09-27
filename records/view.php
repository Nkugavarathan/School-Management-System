<?php include("../config.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <title>View Academic Records</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="container p-5">
    <a href="../dashboard.php" class="btn btn-secondary mb-4">Back to Dashboard</a>
    <h2>Academic Records</h2>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Student</th>
            <th>Subject</th>
            <th>Marks</th>
            <th>Grade</th>
        </tr>
        <?php
        $result = $conn->query("SELECT r.*, s.name FROM academic_records r JOIN students s ON r.student_id=s.student_id");
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['record_id'] . "</td><td>" . $row['name'] . "</td><td>" . $row['subject'] . "</td><td>" . $row['marks'] . "</td><td>" . $row['grade'] . "</td></tr>";
        }
        ?>
    </table>
</body>

</html>