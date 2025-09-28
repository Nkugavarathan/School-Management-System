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

    $remaining = $amount;

    // Fetch unpaid fees in order
    $fees = $conn->query("SELECT * FROM fees WHERE student_id = '$student_id' AND status = 'unpaid' ORDER BY due_date ASC");

    while ($fee = $fees->fetch_assoc()) {
        $fee_id = $fee['fee_id'];
        $due = $fee['due_amount'];

        if ($remaining <= 0) break;

        if ($remaining >= $due) {
            // Full payment for this fee
            $conn->query("UPDATE fees SET due_amount = 0, status = 'paid' WHERE fee_id = '$fee_id'");
            $remaining -= $due;
        } else {
            // Partial payment
            $new_due = $due - $remaining;
            $conn->query("UPDATE fees SET due_amount = '$new_due', status = 'partial' WHERE fee_id = '$fee_id'");
            $remaining = 0;
        }
    }
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