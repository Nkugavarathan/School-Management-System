<?php
include("config.php");
// session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// ------------------
// Student Count
// ------------------
$result = $conn->query("SELECT COUNT(*) AS total FROM students");
$row = $result->fetch_assoc();
$totalStudents = $row['total'] ?? 0;

// ------------------
// Teacher Count
// ------------------
$result = $conn->query("SELECT COUNT(*) AS total FROM teachers");
$row = $result->fetch_assoc();
$totalTeachers = $row['total'] ?? 0;

// ------------------
// Parent Count
// ------------------
$result = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='parent'");
$row = $result->fetch_assoc();
$totalParents = $row['total'] ?? 0;

// ------------------
// Unread Messages Count
// ------------------
$result = $conn->query("SELECT COUNT(*) AS total FROM messages WHERE receiver_id='{$_SESSION['user_id']}' AND is_read=0");
$row = $result->fetch_assoc();
$unreadMessages = $row['total'] ?? 0;


// ------------------
// Today's Attendance
// ------------------
$today = date('Y-m-d');
$result = $conn->query("SELECT COUNT(*) AS total FROM attendance WHERE date='$today'");
$row = $result->fetch_assoc();
$todayAttendance = $row['total'] ?? 0;

// ------------------
// Fees Collected (from payments table)
// ------------------
$result = $conn->query("SELECT SUM(amount) AS total FROM payments");
$row = $result->fetch_assoc();
$feesCollected = $row['total'] ?? 0;

// ------------------
// Fees Due (from fees table)
// ------------------
$result = $conn->query("SELECT SUM(due_amount) AS total FROM fees WHERE status='unpaid'");
$row = $result->fetch_assoc();
$feesDue = $row['total'] ?? 0;

// Sanitize values
$feesCollected = $feesCollected ?: 0;
$feesDue = $feesDue ?: 0;

//Inventory count
$result = $conn->query("SELECT SUM(quantity) AS total FROM inventory");
$row = $result->fetch_assoc();
$totalinventory = $row['total'] ?? 0;
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background-color: #98c5ecff !important;
        }
    </style>

</head>

<body>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary  fw-bold">Admin Dashboard</h2>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <!-- Dashboard Stats -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card shadow p-3 bg-primary text-white text-center">
                    <h5>Students</h5>
                    <h2><?= $totalStudents ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow p-3 bg-success text-white text-center">
                    <h5>Teachers</h5>
                    <h2><?= $totalTeachers ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow p-3 bg-warning text-white text-center">
                    <h5>Parents</h5>
                    <h2><?= $totalParents ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow p-3 bg-info text-white text-center">
                    <h5>Today’s Attendance</h5>
                    <h2><?= $todayAttendance ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow p-3 bg-danger text-white text-center">
                    <h5>Fees Collected</h5>
                    <h2>₹<?= number_format($feesCollected, 2) ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow p-3 bg-secondary text-white text-center">
                    <h5>Unread Messages</h5>
                    <h2><?= $unreadMessages ?></h2>
                    <a href="./messages/inbox.php" class="btn btn-light mt-2">View Messages</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow p-3 bg-info text-white text-center">
                    <h5>Inventory Items</h5>
                    <h2><?= $totalinventory ?></h2>
                    <a href="./inventory/view.php" class="btn btn-light mt-2">View Inventory</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow p-3 bg-primary text-white text-center">

                    <a href="dashboard.php" class="btn btn-light mt-2">Edit User Details</a>
                </div>
            </div>

        </div>

        <!-- Chart Section -->
        <div class="card shadow p-4">
            <h4 class="mb-4 text-center">Fees Analysis</h4>
            <canvas id="feesChart" height="100"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('feesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Fees Collected', 'Fees Unpaid'],

                datasets: [{
                    label: 'Fees (₹)',
                    data: [<?= $feesCollected ?>, <?= $feesDue ?>],
                    backgroundColor: ['#198754', '#dc3545'] // green for collected, red for unpaid

                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Fees Collected vs Due'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₹' + value;
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>