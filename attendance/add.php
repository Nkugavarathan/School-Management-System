<?php
include("../config.php");
// session_start();

// Access control
if ($_SESSION['role'] != 'teacher' && $_SESSION['role'] != 'admin') {
    die("<div class='alert alert-danger text-center mt-5'>Access Denied</div>");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #98c5ecff !important;
        }
    </style>
</head>

<body class=" d-flex justify-content-center align-items-center vh-100 text-white">
    <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;">
        <a href="../dashboard.php" class="btn btn-secondary mb-4">Back to Dashboard</a>

        <h2 class="text-center mb-4">Mark Attendance</h2>

        <?php
        if (isset($_POST['submit'])) {
            $sid = $_POST['student_id'];
            $status = $_POST['status'];
            $date = date("Y-m-d");

            // Check if student exists
            $check = $conn->query("SELECT * FROM students WHERE student_id = '$sid'");
            if ($check->num_rows == 0) {
                echo "<div class='alert alert-danger text-center'>Student ID not found!</div>";
            } else {
                // Insert attendance
                $sql = "INSERT INTO attendance(student_id, date, status) VALUES('$sid', '$date', '$status')";
                if ($conn->query($sql)) {
                    echo "<div class='alert alert-success text-center'>Attendance saved!</div>";
                } else {
                    echo "<div class='alert alert-danger text-center'>Error: " . $conn->error . "</div>";
                }
            }
        }
        ?>

        <form method="POST">
            <div class="mb-3">
                <input type="number" name="student_id" class="form-control" placeholder="Student ID" required>
            </div>
            <div class="mb-3">
                <select name="status" class="form-select" required>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                    <option value="Late">Late</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-100">Save</button>
        </form>
    </div>
</body>

</html>