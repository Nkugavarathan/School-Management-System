<?php
include("../config.php");
?>

<html>

<head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
                body {
                        background-color: #98c5ecff !important;
                }
        </style>
</head>

<body>
        <div class="card mt-5 shadow-lg">
                <div class="card-header bg-dark text-white">📜 Payment Receipts</div>
                <div class="card-body">
                        <?php
                        $sql = "SELECT p.payment_id, s.name, p.amount, p.payment_date, p.receipt_no 
              FROM payments p 
              JOIN students s ON p.student_id = s.student_id
              ORDER BY p.payment_date DESC";
                        $result = $conn->query($sql);
                        ?>
                        <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                        <tr>
                                                <th>Receipt No</th>
                                                <th>Student</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                        </tr>
                                </thead>
                                <tbody>
                                        <?php while ($row = $result->fetch_assoc()) { ?>
                                                <tr>
                                                        <td><?= $row['receipt_no'] ?></td>
                                                        <td><?= $row['name'] ?></td>
                                                        <td><?= $row['amount'] ?></td>
                                                        <td><?= $row['payment_date'] ?></td>
                                                </tr>
                                        <?php } ?>
                                </tbody>
                        </table>
                </div>
        </div>
</body>

</html>