<?php
include("../config.php");
session_start();

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

<form method="post">
    <label>Student ID:</label>
    <input type="number" name="student_id" required><br>
    <label>Amount:</label>
    <input type="number" step="0.01" name="amount" required><br>
    <button type="submit">Pay</button>
</form>