<?php
include("../config.php");

?>

<!DOCTYPE html>
<html>

<head>
    <title>View Academic Records</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light p-5">
    <div class="container">
        <a href="../dashboard.php" class="btn btn-secondary w-100 mb-4">Back to Dashboard</a>
        <h2 class="text-center mb-4">📚 Academic Records</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="table-primary text-center">
                    <tr>
                        <th>Record ID</th>
                        <th>Student Name</th>
                        <th>Subject</th>
                        <th>Marks</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT r.*, s.name FROM academic_records r JOIN students s ON r.student_id = s.student_id");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='text-center'>
                                    <td>{$row['record_id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['subject']}</td>
                                    <td>{$row['marks']}</td>
                                    <td>{$row['grade']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center text-muted'>No academic records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>