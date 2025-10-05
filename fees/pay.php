<?php
include("../config.php");
// session_start();

$downloadLink = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_SESSION['student_id'];
    $amount     = $_POST['amount'];
    $receipt_no = uniqid("REC");

    // Insert payment record
    $conn->query("INSERT INTO payments (student_id, amount, receipt_no, payment_date) VALUES ('$student_id', '$amount', '$receipt_no', NOW())");

    // Sequentially apply payment to unpaid fees
    $remaining = $amount;
    $fees = $conn->query("SELECT * FROM fees WHERE student_id = '$student_id' AND status != 'paid' ORDER BY due_date ASC");

    while ($fee = $fees->fetch_assoc()) {
        $fee_id = $fee['fee_id'];
        $due = $fee['due_amount'];

        if ($remaining <= 0) break;

        if ($remaining >= $due) {
            $conn->query("UPDATE fees SET due_amount = 0, status = 'paid' WHERE fee_id = '$fee_id'");
            $remaining -= $due;
        } else {
            $new_due = $due - $remaining;
            $conn->query("UPDATE fees SET due_amount = '$new_due', status = 'partial' WHERE fee_id = '$fee_id'");
            $remaining = 0;
        }
    }

    // Redirect back with success and receipt number
    header("Location: pay.php?success=1&receipt_no=$receipt_no");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pay Fee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <style>
        body {
            background-color: #98c5ecff !important;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
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

                <?php if (isset($_GET['success']) && $_GET['success'] == 1 && isset($_GET['receipt_no'])): ?>
                    <div class="mt-3 text-center">
                        <a href="generate_receipt.php?receipt_no=<?= $_GET['receipt_no']; ?>"
                            target="_blank" class="btn btn-primary w-100">
                            Download Payment Receipt (PDF)
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Toastify Trigger -->
    <script>
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            Toastify({
                text: "✅ Payment recorded successfully!",
                duration: 4000,
                close: true,
                gravity: "top",
                position: "center",
                backgroundColor: "#198754",
                stopOnFocus: true
            }).showToast();
        <?php endif; ?>
    </script>
</body>

</html>