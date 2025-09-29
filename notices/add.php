<?php
include("../config.php");


if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'teacher'])) {
    die("Access denied");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title     = $conn->real_escape_string($_POST['title']);
    $content   = $conn->real_escape_string($_POST['content']);
    $posted_by = $_SESSION['user_id'];

    $sql = "INSERT INTO announcements (title, content, posted_by, post_date) 
            VALUES ('$title', '$content', '$posted_by', NOW())";

    if ($conn->query($sql)) {
        $success = "✅ Notice posted successfully!";
    } else {
        $error = "❌ " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Notice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #98c5ecff !important;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-6">
        <div class="card shadow-lg w-100">
            <div class="card-header bg-primary text-white text-center">
                📢 Add Notice
            </div>
            <div class="card-body">
                <a href="manage.php" class="btn btn-secondary w-100 mb-3">Back to Notices</a>

                <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
                <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="content" class="form-control" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Post Notice</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>