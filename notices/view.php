<?php
include("../config.php");
// session_start();

// Only students/parents allowed
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['student', 'parent', 'admin', 'teacher'])) {
    die("Access denied");
}

// Fetch all announcements
$sql = "SELECT a.*, u.username AS posted_by_name 
        FROM announcements a 
        JOIN users u ON a.posted_by = u.user_id 
        ORDER BY a.post_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Notice Board</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #98c5ecff !important;
        }
    </style>
</head>

<body class="container py-5">
    <h2 class="mb-4 text-center">Notice Board</h2>
    <a href="../dashboard.php" class="btn btn-secondary mb-4">Back to Dashboard</a>

    <div class="row">
        <?php if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0"><?= htmlspecialchars($row['title']) ?></h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <small>Posted by: <?= htmlspecialchars($row['posted_by_name']) ?></small>
                            <small><?= date("d M Y, H:i", strtotime($row['post_date'])) ?></small>
                        </div>
                    </div>
                </div>
            <?php }
        } else { ?>
            <p class="text-center">No notices available.</p>
        <?php } ?>
    </div>
</body>

</html>