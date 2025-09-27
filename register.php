<?php include("config.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Register User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="container p-5">
    <h2>Register New User</h2>
    <form method="POST">
        <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
        <select name="role" class="form-control mb-2">
            <option value="admin">Admin</option>
            <option value="teacher">Teacher</option>
            <option value="student">Student</option>
            <option value="parent">Parent</option>
        </select>
        <button class="btn btn-primary" name="register">Register</button>
    </form>
</body>

</html>

<?php
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users(username,password,role) VALUES('$username','$password','$role')";
    if ($conn->query($sql)) {
        echo "<div class='alert alert-success mt-3'>User registered!</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Error: " . $conn->error . "</div>";
    }
}
?>