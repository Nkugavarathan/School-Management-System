<?php
include("../config.php");
// session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $due_amount = $_POST['due_amount'];
    $due_date   = $_POST['due_date'];

    $sql = "INSERT INTO fees (student_id, due_amount, due_date) 
            VALUES ('$student_id', '$due_amount', '$due_date')";

    if ($conn->query($sql)) {
        echo "Fee added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>



<html>

<head>
    <meta charset="UTF-8">
    <title>Fee Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <h2 class="text-center mb-4">💰 Fee Management</h2>

        <div class="row g-4">
            <!-- Add Fee -->
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">Add Fee</div>
                    <div class="card-body">
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

</body>

</html>