<?php include("config.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <!-- <style>
        * {
            background: linear-gradient(to right, rgba(13, 110, 253, 0.7), rgba(11, 30, 63, 0.7));
        }
    </style> -->
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class=" bg-primary d-flex justify-content-center align-items-center vh-100 text-white">

    <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;">
        <a href="index.php" class="btn btn-danger w-100 mb-1">Back to Homepage</a>

        <h2 class="text-center mb-4">Login</h2>
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="text-center mt-3 mb-0">
            Don't have an account? <a href="register.php" class="text-decoration-underline">Register here</a>
        </p>
    </div>
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

            if ($row['role'] == "teacher") {
                $tq = $conn->query("SELECT teacher_id FROM teachers WHERE user_id = '" . $row['user_id'] . "'");
                if ($tq && $tq->num_rows > 0) {
                    $trow = $tq->fetch_assoc();
                    $_SESSION['teacher_id'] = $trow['teacher_id'];
                }
            }

            if ($row['role'] == "admin") {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
            exit();
        } else {
            echo "<div class='alert alert-danger text-center mt-3'>Invalid password!</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center mt-3'>User not found!</div>";
    }
}
?>