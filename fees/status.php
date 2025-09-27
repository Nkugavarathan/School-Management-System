<?php
include("../config.php");

?>

<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

    <div class="card mt-5 shadow-lg">
        <a href="../dashboard.php" class="btn btn-secondary mb-4">Back to Dashboard</a>

        <div class="card-header bg-info text-white">🔎 View Student Fee Status</div>
        <div class="card-body">
            <form method="post" class="row g-3">
                <div class="col-md-10">
                    <input type="number" name="student_id" class="form-control" placeholder="Enter Student ID" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info w-100 text-white">Check</button>
                </div>
            </form>

            <?php
            $student_id = isset($_POST['student_id']) ? $_POST['student_id'] : null;
            if ($student_id) {
                $sql_student = "SELECT * FROM students WHERE student_id = '$student_id'";
                $res_student = $conn->query($sql_student);

                if ($res_student->num_rows > 0) {
                    $student = $res_student->fetch_assoc();
                    echo "<h4 class='mt-4'>👨‍🎓 {$student['name']} (ID: {$student['student_id']})</h4>";

                    // Fee Dues
                    $sql_fees = "SELECT * FROM fees WHERE student_id = '$student_id'";
                    $res_fees = $conn->query($sql_fees);
                    echo "<h5 class='mt-3 text-danger'>Outstanding Fees</h5>";
                    echo "<table class='table table-bordered table-hover'>
                  <thead class='table-danger'>
                    <tr>
                      <th>Fee ID</th>
                      <th>Due Amount</th>
                      <th>Status</th>
                      <th>Due Date</th>
                    </tr>
                  </thead><tbody>";
                    while ($fee = $res_fees->fetch_assoc()) {
                        echo "<tr>
                    <td>{$fee['fee_id']}</td>
                    <td>{$fee['due_amount']}</td>
                    <td>{$fee['status']}</td>
                    <td>{$fee['due_date']}</td>
                  </tr>";
                    }
                    echo "</tbody></table>";

                    // Payments
                    $sql_payments = "SELECT * FROM payments WHERE student_id = '$student_id'";
                    $res_payments = $conn->query($sql_payments);
                    echo "<h5 class='mt-3 text-success'>Payments Made</h5>";
                    echo "<table class='table table-bordered table-hover'>
                  <thead class='table-success'>
                    <tr>
                      <th>Payment ID</th>
                      <th>Amount</th>
                      <th>Date</th>
                      <th>Receipt No</th>
                    </tr>
                  </thead><tbody>";
                    while ($pay = $res_payments->fetch_assoc()) {
                        echo "<tr>
                    <td>{$pay['payment_id']}</td>
                    <td>{$pay['amount']}</td>
                    <td>{$pay['payment_date']}</td>
                    <td>{$pay['receipt_no']}</td>
                  </tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<div class='alert alert-danger mt-3'>⚠️ Student not found!</div>";
                }
            }
            ?>
        </div>
    </div>
</body>

</html>
<!-- Check Fee Status -->