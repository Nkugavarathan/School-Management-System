<?php
include("../config.php");
// session_start();

$sql = "SELECT m.*, t.name as teacher_name 
        FROM materials m 
        LEFT JOIN teachers t ON m.teacher_id = t.teacher_id 
        ORDER BY m.upload_date DESC";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Study Materials</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #98c5ecff !important;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <h2 class="text-center mb-4">📚 Study Materials</h2>
        <div class="text-center mb-4">
            <a href="../dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>

        <div class="card shadow p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Uploaded By</th>
                            <th>Date</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $res->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><?= htmlspecialchars($row['description']) ?></td>
                                <td><?= htmlspecialchars($row['teacher_name'] ?? 'Admin') ?></td>
                                <td><?= htmlspecialchars($row['upload_date']) ?></td>
                                <td>
                                    <a href="<?= htmlspecialchars($row['file_path']) ?>" class="btn btn-sm btn-success" download>Download</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php if ($res->num_rows == 0): ?>
                            <tr>
                                <td colspan="5" class="text-center">No materials uploaded yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>