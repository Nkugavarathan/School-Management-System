<?php
include("../config.php");
// session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_SESSION['student_id']; // ✅ Use session
    $amount     = $_POST['amount'];
    $receipt_no = uniqid("REC");

    $sql = "INSERT INTO payments (student_id, amount, receipt_no) 
            VALUES ('$student_id', '$amount', '$receipt_no')";
    $conn->query($sql);

    $sql2 = "UPDATE fees 
             SET due_amount = due_amount - $amount,
                 status = CASE
                            WHEN due_amount - $amount <= 0 THEN 'paid'
                            ELSE 'partial'
                          END
             WHERE student_id = '$student_id'";
    $conn->query($sql2);

    echo "✅ Payment recorded successfully! Receipt No: " . $receipt_no;
}
?>

<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-6">
        <a href="../dashboard.php" class="btn btn-secondary mb-4 ">Back to Dashboard</a>

        <div class="card shadow-lg w-100">

            <div class="card-header bg-success text-white text-center">Pay Fee</div>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" step="0.01" name="amount" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Pay</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>