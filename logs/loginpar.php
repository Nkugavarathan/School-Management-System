<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "smartschool",3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$Email = isset($_POST['Email']) ? $_POST['Email'] : '';
$Password = isset($_POST['Password']) ? $_POST['Password'] : '';

// Case-insensitive email check
$sql = "SELECT * FROM users WHERE LOWER(Email) = LOWER(?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $Email);
$stmt->execute();
$result = $stmt->get_result();

if ($users = $result->fetch_assoc()) {
    if (password_verify($Password, $users['Password'])) {
        $_SESSION['user_id'] = $users['user_id'];
        $_SESSION['name'] = $users['Name'];

        echo "<script>
            alert('Login successful. Welcome " . addslashes($users['Name']) . "');
            window.location.href = 'dashboardpar.html';
        </script>";
    } else {
        echo "<script>
            alert('Invalid password.');
            window.location.href = 'login.html';
        </script>";
    }
} else {
    echo "<script>
        alert('No account found with that email.');
        window.location.href = 'signup.html';
    </script>";
}

$stmt->close();
$conn->close();
?>
