<?php include("config.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-primary d-flex justify-content-center align-items-center vh-100 text-white">
    <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;">
        <a href="index.php" class="btn btn-danger w-100 mb-1">Back to Homepage</a>
        <h2 class="text-center mb-4">Register New User</h2>
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="mb-3">
                <select name="role" class="form-select" required>
                    <option value="" disabled selected>Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                    <option value="parent">Parent</option>
                </select>
            </div>
            <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
        </form>
        <p class="text-center mt-3 mb-0">
            Already have an account? <a href="login.php" class="text-decoration-underline">Login here</a>
        </p>
        <?php if (isset($_GET['registered'])): ?>
            <div class="alert alert-success text-center">User registered successfully! Please log in.</div>
        <?php endif; ?>
    </div>
</body>

</html>

<?php
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role     = $_POST['role'];

    // Check if user already exists with same username and role
    $checkSql = "SELECT * FROM users WHERE username='$username' AND role='$role'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        echo "<div class='alert alert-danger text-center mt-3'>User already exists with this role!</div>";
    } else {
        $sql = "INSERT INTO users(username,password,role) VALUES('$username','$password','$role')";
        if ($conn->query($sql)) {
            header("Location: login.php?registered=1");
            exit();
        } else {
            echo "<div class='alert alert-danger text-center mt-3'>Error: " . $conn->error . "</div>";
        }
    }
}
?>