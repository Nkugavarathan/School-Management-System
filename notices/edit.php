<?php
include("../config.php");
// session_start();

// Only Admin or Teacher can edit
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'teacher'])) {
    die("Access denied");
}

// Get the notice ID from URL
if (!isset($_GET['id'])) die("Notice ID missing");
$id = $_GET['id'];

// Fetch notice from DB
$sql = "SELECT * FROM announcements WHERE announcement_id='$id'";
$res = $conn->query($sql);
if ($res->num_rows == 0) die("Notice not found");
$notice = $res->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

    $update_sql = "UPDATE announcements 
                   SET title='$title', content='$content' 
                   WHERE announcement_id='$id'";
    if ($conn->query($update_sql)) {
        header("Location: manage.php");
        exit();
    } else {
        $error = $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Notice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="container p-5">
    <h2>Edit Notice</h2>
    <a href="manage.php" class="btn btn-secondary mb-3">Back to Notices</a>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Title:</label>
            <input type="text" name="title" class="form-control" value="<?= $notice['title'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Content:</label>
            <textarea name="content" class="form-control" rows="5" required><?= $notice['content'] ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Notice</button>
    </form>
</body>

</html>