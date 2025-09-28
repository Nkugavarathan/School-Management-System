<?php
include("../config.php");


if ($_SESSION['role'] != 'teacher' && $_SESSION['role'] != 'admin') {
    die("Access Denied");
}

if (isset($_POST['submit'])) {
    $sid     = $_POST['student_id'];
    $subject = $_POST['subject'];
    $marks   = $_POST['marks'];
    $grade   = $_POST['grade'];

    $sql = "INSERT INTO academic_records(student_id, subject, marks, grade) 
            VALUES('$sid', '$subject', '$marks', '$grade')";
    if ($conn->query($sql)) {
        $success = "✅ Record added successfully!";
    } else {
        $error = "❌ " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Academic Record</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-6">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                📘 Add Academic Record
            </div>
            <div class="card-body">
                <a href="../dashboard.php" class="btn btn-secondary w-100 mb-3">Back to Dashboard</a>

                <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
                <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Student ID</label>
                        <input type="number" name="student_id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Marks</label>
                        <input type="number" name="marks" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Grade</label>
                        <input type="text" name="grade" class="form-control" required>
                    </div>
                    <button class="btn btn-success w-100" name="submit">Save Record</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>