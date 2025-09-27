<?php
include("../config.php");
// session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $amount     = $_POST['amount'];
    $receipt_no = uniqid("REC"); // auto-generate receipt no

    // Insert payment
    $sql = "INSERT INTO payments (student_id, amount, receipt_no) 
            VALUES ('$student_id', '$amount', '$receipt_no')";
    $conn->query($sql);

    // Update fees table
    $sql2 = "UPDATE fees 
             SET due_amount = due_amount - $amount,
                 status = CASE
                            WHEN due_amount - $amount <= 0 THEN 'paid'
                            ELSE 'partial'
                          END
             WHERE student_id = '$student_id'";
    $conn->query($sql2);

    echo "Payment recorded successfully! Receipt No: " . $receipt_no;
}
?>

<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<div class="col-md-6">
    <div class="card shadow-lg">
        <div class="card-header bg-success text-white">Pay Fee</div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Student ID</label>
                    <input type="number" name="student_id" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Amount</label>
                    <input type="number" step="0.01" name="amount" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Pay</button>
            </form>
        </div>
    </div>
</div>

</html>