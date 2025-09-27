<?php include("../config.php");
if ($_SESSION['role'] != 'teacher' && $_SESSION['role'] != 'admin') {
    die("Access Denied");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="container p-5">
    <h2>Mark Attendance</h2>
    <form method="POST">
        <input type="number" name="student_id" class="form-control mb-2" placeholder="Student ID" required>
        <select name="status" class="form-control mb-2">
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
            <option value="Late">Late</option>
        </select>
        <button class="btn btn-primary" name="submit">Save</button>
    </form>
</body>

</html>

<?php
if (isset($_POST['submit'])) {
    $sid = $_POST['student_id'];
    $status = $_POST['status'];
    $date = date("Y-m-d");

    $sql = "INSERT INTO attendance(student_id,date,status) VALUES('$sid','$date','$status')";
    if ($conn->query($sql)) {
        echo "<div class='alert alert-success mt-3'>Attendance saved!</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>" . $conn->error . "</div>";
    }
}
?>