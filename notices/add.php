<?php
include("../config.php");

$role = strtolower($_SESSION['role']);
if ($role != 'admin' && $role != 'teacher') {
    die("Access denied");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $posted_by = $_SESSION['user_id'];

    $sql = "INSERT INTO announcements (title, content, posted_by)
            VALUES ('$title', '$content', '$posted_by')";

    if ($conn->query($sql)) {
        echo "<p style='color:green;'>Announcement posted successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<h2>Add Announcement</h2>
<form method="post">
    <label>Title:</label>
    <input type="text" name="title" required><br>

    <label>Content:</label>
    <textarea name="content" required></textarea><br>

    <button type="submit">Post Announcement</button>
</form>