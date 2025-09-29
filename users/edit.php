<?php
include("../config.php");
// session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") die("Access denied");

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE user_id='$id'";
$res = $conn->query($sql);
if ($res->num_rows == 0) die("User not found");
$user = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET username='$username', role='$role', password='$password' WHERE user_id='$id'";
    } else {
        $sql = "UPDATE users SET username='$username', role='$role' WHERE user_id='$id'";
    }

    if ($conn->query($sql)) header("Location: manage.php");
    else $error = $conn->error;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #98c5ecff !important;
        }
    </style>
</head>

<body class="container p-5">
    <h2>Edit User</h2>
    <a href="manage.php" class="btn btn-secondary mb-3">Back</a>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Username:</label>
            <input type="text" name="username" class="form-control" value="<?= $user['username'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Role:</label>
            <select name="role" class="form-control" required>
                <option value="admin" <?= $user['role'] == "admin" ? "selected" : "" ?>>Admin</option>
                <option value="teacher" <?= $user['role'] == "teacher" ? "selected" : "" ?>>Teacher</option>
                <option value="student" <?= $user['role'] == "student" ? "selected" : "" ?>>Student</option>
                <option value="parent" <?= $user['role'] == "parent" ? "selected" : "" ?>>Parent</option>
            </select>
        </div>
        <div class="mb-3">
            <label>New Password (leave blank to keep current):</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</body>

</html>