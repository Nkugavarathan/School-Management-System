<?php
include("../config.php");


if (!isset($_SESSION['user_id'])) {
    die("Access denied");
}

if (isset($_POST['send'])) {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];

    $sql = "INSERT INTO messages (sender_id, receiver_id, subject, body) 
            VALUES ('$sender_id', '$receiver_id', '$subject', '$body')";
    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>Message sent successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// fetch all users (for dropdown)
$users = $conn->query("SELECT user_id, username, role FROM users WHERE user_id != " . $_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Send Message</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="container py-5">
    <h2>Send Message</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">To</label>
            <select name="receiver_id" class="form-control" required>
                <?php while ($u = $users->fetch_assoc()) { ?>
                    <option value="<?= $u['user_id'] ?>">
                        <?= $u['username'] ?> (<?= $u['role'] ?>)
                    </option>
                <?php } ?>
            </select>
        </div>
        <input type="text" name="subject" class="form-control mb-3" placeholder="Subject" required>
        <textarea name="body" class="form-control mb-3" rows="5" placeholder="Message body" required></textarea>
        <button type="submit" name="send" class="btn btn-primary">Send</button>
        <a href="inbox.php" class="btn btn-secondary">Go to Inbox</a>
    </form>
</body>

</html>