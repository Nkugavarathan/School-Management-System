<?php
include("config.php");
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            background-color: #98c5ecff !important;
        }
    </style>
    <title>LogIn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class=" d-flex justify-content-center align-items-center vh-100 text-white">

    <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;">
        <a href="index.php" class="btn btn-secondary w-100 mb-1">Back to Homepage</a>

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

    // Use prepared statement for security
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role']    = $row['role'];
            $_SESSION['username'] = $row['username'];

            // If teacher, store teacher_id
            if ($row['role'] === "teacher") {
                $tq = $conn->prepare("SELECT teacher_id FROM teachers WHERE user_id = ?");
                $tq->bind_param("i", $row['user_id']);
                $tq->execute();
                $tres = $tq->get_result();
                if ($tres->num_rows > 0) {
                    $trow = $tres->fetch_assoc();
                    $_SESSION['teacher_id'] = $trow['teacher_id'];
                }
            }

            // If student, store student_id
            if ($row['role'] === "student") {
                $sq = $conn->prepare("SELECT student_id FROM students WHERE user_id = ?");
                $sq->bind_param("i", $row['user_id']);
                $sq->execute();
                $sres = $sq->get_result();
                if ($sres->num_rows > 0) {
                    $srow = $sres->fetch_assoc();
                    $_SESSION['student_id'] = $srow['student_id'];
                }
            }

            // Redirect based on role
            if ($row['role'] === "admin") {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            echo "<div class='alert alert-danger text-center mt-3'>Invalid password!</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center mt-3'>User not found!</div>";
    }
}
