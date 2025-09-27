<?php
include("../config.php");
session_start();

$sql = "SELECT p.payment_id, s.name, p.amount, p.payment_date, p.receipt_no 
        FROM payments p 
        JOIN students s ON p.student_id = s.student_id
        ORDER BY p.payment_date DESC";
$result = $conn->query($sql);

echo "<h2>Receipts</h2>";
echo "<table border='1'>
        <tr>
            <th>Receipt No</th>
            <th>Student</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['receipt_no']}</td>
            <td>{$row['name']}</td>
            <td>{$row['amount']}</td>
            <td>{$row['payment_date']}</td>
          </tr>";
}
echo "</table>";
