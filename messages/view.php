<?php
include("../config.php");


if (!isset($_SESSION['user_id'])) {
    die("Access denied");
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// fetch message
$sql = "SELECT m.*, u.username AS sender_name 
        FROM messages m 
        JOIN users u ON m.sender_id = u.user_id
        WHERE message_id='$id' AND receiver_id='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Message not found!");
}

$row = $result->fetch_assoc();

// mark as read
$conn->query("UPDATE messages SET is_read=1 WHERE message_id='$id'");
?>
<!DOCTYPE html>
<html>

<head>
    <title>View Message</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #98c5ecff !important;
        }
    </style>
</head>

<body class="container py-5">
    <a href="../dashboard.php" class="btn btn-secondary mb-4">Back to Dashboard</a>
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><?= htmlspecialchars($row['subject']) ?></h5>
        </div>
        <div class="card-body">
            <p class="mb-2"><strong>From:</strong> <?= htmlspecialchars($row['sender_name']) ?></p>
            <p class="mb-2"><strong>Date:</strong> <?= $row['sent_at'] ?></p>
            <hr>
            <p><?= nl2br(htmlspecialchars($row['body'])) ?></p>
        </div>
    </div>

    <a href="inbox.php" class="btn btn-secondary">Back to Inbox</a>
</body>

</html>