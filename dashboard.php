<?php
include("config.php");


if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #98c5ecff !important;
        }
    </style>
</head>

<body class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <?php if ($role == "admin") { ?>
            <a href="admin_dashboard.php" class="btn btn-primary me-2">Back to Admin Dashboard</a>
        <?php } ?>
        <h2 class="fw-bold">Welcome, <span class="text-primary"><?= ucfirst($role) ?></span>!</h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <div class="row g-3">

        <!-- Admin Dashboard -->
        <?php if ($role == "admin") { ?>
            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5>User Management</h5>
                    <a href="users/manage.php" class="btn btn-primary mt-2">Manage Users</a>

                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5>Attendance</h5>
                    <a href="attendance/add.php" class="btn btn-primary mt-2">Mark Attendance</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5>Academic Records</h5>
                    <a href="records/add.php" class="btn btn-success mt-2">Add Record</a>
                    <a href="records/view.php" class="btn btn-info mt-2">View Records</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5>Fee Management</h5>
                    <a href="fees/add.php" class="btn btn-warning mt-2">Manage Fees</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5>Study Materials</h5>
                    <a href="materials/upload.php" class="btn btn-success mt-2">Upload</a>
                    <a href="materials/list.php" class="btn btn-info mt-2">View</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5>Notice Board</h5>
                    <a href="notices/add.php" class="btn btn-primary mt-2">Post Notice</a>
                    <a href="notices/view.php" class="btn btn-info mt-2">View Notices</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5>Inventory Management</h5>
                    <a href="inventory/view.php" class="btn btn-primary mt-2">Manage Inventory</a>
                </div>
            </div>
        <?php } ?>

        <!-- Teacher Dashboard -->
        <?php if ($role == "teacher") { ?>
            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5>Attendance</h5>
                    <a href="attendance/add.php" class="btn btn-primary mt-2">Mark Attendance</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5>Academic Records</h5>
                    <a href="records/add.php" class="btn btn-success mt-2">Add Record</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5>Study Materials</h5>
                    <a href="materials/upload.php" class="btn btn-success mt-2">Upload</a>
                    <a href="materials/list.php" class="btn btn-info mt-2">View</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5>Notice Board</h5>
                    <a href="notices/add.php" class="btn btn-primary mt-2">Post Notice</a>
                    <a href="notices/view.php" class="btn btn-info mt-2">View Notices</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5>View Inventory</h5>
                    <a href="inventory/view.php" class="btn btn-primary mt-2">Manage Inventory</a>
                </div>
            </div>
        <?php } ?>

        <!-- Student & Parent Dashboard -->
        <?php if ($role == "student" || $role == "parent") { ?>
            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5>Attendance</h5>
                    <a href="attendance/view.php" class="btn btn-info mt-2">View Attendance</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5>Academic Records</h5>
                    <a href="records/view.php" class="btn btn-info mt-2">View Records</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5>Fee Status</h5>
                    <a href="fees/pay.php" class="btn btn-info mt-2">Pay Fees</a>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'student'): ?>

                        <a href="fees/status.php" class="btn btn-warning mt-2">View Fees</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5>Study Materials</h5>
                    <a href="materials/list.php" class="btn btn-info mt-2">Download</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5>Notice Board</h5>
                    <a href="notices/view.php" class="btn btn-info mt-2">View Notices</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5>Inventory Items</h5>
                    <a href="inventory/view.php" class="btn btn-primary mt-2"> View Inventory</a>
                </div>
            </div>


        <?php } ?>

        <!-- Messaging Card (Visible to all roles) -->
        <div class="col-md-4">
            <div class="card p-3 shadow">
                <h5>Messaging System</h5>
                <a href="messages/inbox.php" class="btn btn-primary mt-2">Go to Messages</a>
            </div>
        </div>

        <!-- media  -->
        <div class="col-md-4">
            <div class="card p-3 shadow">
                <h5>Media Gallery</h5>
                <?php if ($role == "admin" || $role == "teacher") { ?>
                    <a href="media/upload.php" class="btn btn-success mt-2">Upload Media</a>
                <?php } ?>
                <a href="media/gallery.php" class="btn btn-info mt-2">View Gallery</a>
            </div>
        </div>

    </div>

</body>

</html>

</html>