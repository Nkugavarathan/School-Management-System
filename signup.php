<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "smartschool",3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: signup.html');
    exit();
}

// Collect and sanitize form inputs
$name       = isset($_POST['name']) ? trim($_POST['name']) : '';
$email      = isset($_POST['email']) ? trim($_POST['email']) : '';
$id_number  = isset($_POST['id_number']) ? trim($_POST['id_number']) : '';
$role       = isset($_POST['role']) ? trim($_POST['role']) : '';
$password   = isset($_POST['password']) ? $_POST['password'] : '';
$confirm_pw = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

// Validate required fields
if ($name === '' || $email === '' || $id_number === '' || $role === '' || $password === '' || $confirm_pw === '') {
    echo "<script>alert('All fields are required'); window.location.href='signup.html';</script>";
    exit();
}

// Validate password confirmation
if ($password !== $confirm_pw) {
    echo "<script>alert('Passwords do not match'); window.location.href='signup.html';</script>";
    exit();
}

// Check if email or ID already exists
$check_stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ? OR identification_number = ?");
$check_stmt->bind_param("ss", $email, $id_number);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    echo "<script>alert('Email or Identification Number already registered'); window.location.href='signup.html';</script>";
    exit();
}
$check_stmt->close();

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert new user
$insert_stmt = $conn->prepare("INSERT INTO users (name, email, identification_number, password, role) VALUES (?, ?, ?, ?, ?)");
$insert_stmt->bind_param("sssss", $name, $email, $id_number, $hashed_password, $role);

if ($insert_stmt->execute()) {
    echo "<script>alert('Signup successful! You can now log in.'); window.location.href='login.html';</script>";
} else {
    echo "<script>alert('Error occurred while signing up'); window.location.href='signup.html';</script>";
}

$insert_stmt->close();
$conn->close();
?>
