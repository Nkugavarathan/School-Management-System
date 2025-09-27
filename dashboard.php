<?php include("config.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<!-- <body class="container p-5">
    <h2>Welcome, <?php echo $_SESSION['role']; ?>!</h2>
    <a href="logout.php" class="btn btn-danger">Logout</a>

    <?php if ($_SESSION['role'] == "teacher" || $_SESSION['role'] == "admin") { ?>
        <h4 class="mt-3">Teacher/Admin Actions</h4>
        <a href="attendance/add.php" class="btn btn-primary">Mark Attendance</a>
        <a href="records/add.php" class="btn btn-success">Add Academic Record</a>
    <?php } ?>

    <?php if ($_SESSION['role'] == "student" || $_SESSION['role'] == "parent") { ?>
        <h4 class="mt-3">Student/Parent Actions</h4>
        <a href="attendance/view.php" class="btn btn-info">View Attendance</a>
        <a href="records/view.php" class="btn btn-warning">View Academic Records</a>
    <?php } ?>
</body> -->
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
</head>

<body class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Welcome, <span class="text-primary"><?= ucfirst($role) ?></span>!</h2>
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
                    <a href="fees/list.php" class="btn btn-warning mt-2">Manage Fees</a>
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
                    <a href="notices/list.php" class="btn btn-info mt-2">View Notices</a>
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
                    <a href="notices/list.php" class="btn btn-info mt-2">View Notices</a>
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
                    <a href="fees/status.php" class="btn btn-warning mt-2">View Fees</a>
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
                    <a href="notices/list.php" class="btn btn-info mt-2">View Notices</a>
                </div>
            </div>
        <?php } ?>

    </div>

</body>

</html>

</html>