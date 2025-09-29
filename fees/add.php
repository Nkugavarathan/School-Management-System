<?php
include("../config.php");
// session_start();

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $due_amount = $_POST['due_amount'];
    $due_date   = $_POST['due_date'];

    $sql = "INSERT INTO fees (student_id, due_amount, due_date) 
            VALUES ('$student_id', '$due_amount', '$due_date')";

    if ($conn->query($sql)) {
        $success = "💸 Fee added successfully! Student ID: $student_id";
    } else {
        $error = "❌ Error: " . $conn->error;
    }
}
?>


<html>

<head>
    <meta charset="UTF-8">
    <title>Fee Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #98c5ecff !important;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <a href="../dashboard.php" class="btn btn-secondary  mb-3">Back to Dashboard</a>
        <h2 class="text-center mb-4">💰 Fee Management</h2>

        <div class="d-flex justify-content-center align-items-start" style="min-height: 60vh;">
            <div class="col-md-6">
                <div class="card shadow-lg w-100">
                    <div class="card-header bg-primary text-white text-center">Add Fee</div>
                    <div class="card-body">

                        <?php if ($success): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= $success ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= $error ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">Student ID</label>
                                <input type="number" name="student_id" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Due Amount</label>
                                <input type="number" step="0.01" name="due_amount" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Due Date</label>
                                <input type="date" name="due_date" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Add Fee</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS for dismissible alerts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>