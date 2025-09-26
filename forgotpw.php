<?php
session_start();

// DB connection
$conn = new mysqli("localhost", "root", "", "smartschool", 3306);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Check if user exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->fetch_assoc()) {
        // Update password
        $stmt = $conn->prepare("UPDATE users SET Password = ? WHERE Email = ?");
        $stmt->bind_param("ss", $new_password, $email);

        if ($stmt->execute()) {
            echo "<script>
                alert('Password reset successful! Please log in.');
                window.location.href = 'login.html';
            </script>";
        } else {
            echo "<script>
                alert('Error resetting password.');
                window.history.back();
            </script>";
        }
    } else {
        echo "<script>
            alert('No account found with that email.');
            window.history.back();
        </script>";
    }
}
?>
