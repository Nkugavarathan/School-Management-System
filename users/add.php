<?php
include("../config.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    die("Access denied");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Insert into users table
    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    if ($conn->query($sql)) {
        $newUserId = $conn->insert_id;

        // If role is student, insert into students table
        if ($role === 'student') {
            $studentName = $_POST['student_name'];
            $sql2 = "INSERT INTO students (user_id, name) VALUES ('$newUserId', '$studentName')";
            $conn->query($sql2);
        }

        header("Location: manage.php");
        exit();
    } else {
        $error = $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Add User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script>
        function toggleStudentField() {
            const role = document.querySelector('select[name="role"]').value;
            document.getElementById('studentNameField').style.display = role === 'student' ? 'block' : 'none';
        }
    </script>
</head>

<body class="container p-5">
    <h2>Add New User</h2>
    <a href="manage.php" class="btn btn-secondary mb-3">Back to Manage Users</a>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Username:</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Role:</label>
            <select name="role" class="form-control" onchange="toggleStudentField()" required>
                <option value="admin">Admin</option>
                <option value="teacher">Teacher</option>
                <option value="student">Student</option>
                <option value="parent">Parent</option>
            </select>
        </div>
        <div class="mb-3" id="studentNameField" style="display:none;">
            <label>Student Name:</label>
            <input type="text" name="student_name" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Add User</button>
    </form>
</body>

</html>