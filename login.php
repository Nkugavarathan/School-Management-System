<?php
include("config.php");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="container p-5">
    <h2>Login</h2>
    <form method="POST">
        <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
        <button class="btn btn-primary" name="login">Login</button>
    </form>
</body>

</html>

<?php
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role']    = $row['role'];

            // ✅ Add this for teacher
            if ($row['role'] == "teacher") {
                $_SESSION['teacher_id'] = $row['user_id'];
                // or $row['teacher_id'] if you have a separate column
            }

            header("Location: dashboard.php");
            exit();
        } else {
            echo "<div class='alert alert-danger mt-3'>Invalid password!</div>";
        }
    } else {
        echo "<div class='alert alert-danger mt-3'>User not found!</div>";
    }
}
?>