<?php
include("../config.php");
// session_start();

if (!isset($_SESSION['user_id'])) {
    die("Access denied");
}

$user_id = $_SESSION['user_id'];

// fetch received messages
$sql = "SELECT m.*, u.username AS sender_name 
        FROM messages m 
        JOIN users u ON m.sender_id = u.user_id
        WHERE receiver_id = '$user_id' 
        ORDER BY sent_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Inbox</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="container py-5">
    <h2>Inbox</h2>
    <a href="send.php" class="btn btn-primary mb-3">Compose</a>
    <a href="../dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>From</th>
                <th>Subject</th>
                <th>Received</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['sender_name']) ?></td>
                    <td><a href="view.php?id=<?= $row['message_id'] ?>"><?= htmlspecialchars($row['subject']) ?></a></td>
                    <td><?= date("d M Y, H:i", strtotime($row['sent_at'])) ?></td>
                    <td><?= $row['is_read'] ? "Read" : "Unread" ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>