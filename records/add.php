<?php include("../config.php");
if ($_SESSION['role'] != 'teacher' && $_SESSION['role'] != 'admin') {
    die("Access Denied");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Academic Record</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="container p-5">
    <h2>Add Academic Record</h2>
    <form method="POST">
        <input type="number" name="student_id" class="form-control mb-2" placeholder="Student ID" required>
        <input type="text" name="subject" class="form-control mb-2" placeholder="Subject" required>
        <input type="number" name="marks" class="form-control mb-2" placeholder="Marks" required>
        <input type="text" name="grade" class="form-control mb-2" placeholder="Grade" required>
        <button class="btn btn-success" name="submit">Save</button>
    </form>
</body>

</html>

<?php
if (isset($_POST['submit'])) {
    $sid = $_POST['student_id'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];
    $grade = $_POST['grade'];

    $sql = "INSERT INTO academic_records(student_id,subject,marks,grade) VALUES('$sid','$subject','$marks','$grade')";
    if ($conn->query($sql)) {
        echo "<div class='alert alert-success mt-3'>Record added!</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>" . $conn->error . "</div>";
    }
}
?>