<?php
include("../config.php");
// session_start();

// For students/parents, auto-set their student_id from session
// For now, allow Admin/Teacher to search manually
$student_id = isset($_POST['student_id']) ? $_POST['student_id'] : null;
?>

<h2>View Student Fee Status</h2>

<form method="post">
    <label>Enter Student ID:</label>
    <input type="number" name="student_id" required>
    <button type="submit">Check</button>
</form>

<?php
if ($student_id) {
    // Get student info
    $sql_student = "SELECT * FROM students WHERE student_id = '$student_id'";
    $res_student = $conn->query($sql_student);

    if ($res_student->num_rows > 0) {
        $student = $res_student->fetch_assoc();
        echo "<h3>Student: {$student['name']} (ID: {$student['student_id']})</h3>";

        // Show Fee Dues
        $sql_fees = "SELECT * FROM fees WHERE student_id = '$student_id'";
        $res_fees = $conn->query($sql_fees);

        echo "<h4>Fee Dues</h4>";
        echo "<table border='1'>
                <tr>
                    <th>Fee ID</th>
                    <th>Due Amount</th>
                    <th>Status</th>
                    <th>Due Date</th>
                </tr>";

        while ($fee = $res_fees->fetch_assoc()) {
            echo "<tr>
                    <td>{$fee['fee_id']}</td>
                    <td>{$fee['due_amount']}</td>
                    <td>{$fee['status']}</td>
                    <td>{$fee['due_date']}</td>
                  </tr>";
        }
        echo "</table>";

        // Show Payments
        $sql_payments = "SELECT * FROM payments WHERE student_id = '$student_id'";
        $res_payments = $conn->query($sql_payments);

        echo "<h4>Payments</h4>";
        echo "<table border='1'>
                <tr>
                    <th>Payment ID</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Receipt No</th>
                </tr>";

        while ($pay = $res_payments->fetch_assoc()) {
            echo "<tr>
                    <td>{$pay['payment_id']}</td>
                    <td>{$pay['amount']}</td>
                    <td>{$pay['payment_date']}</td>
                    <td>{$pay['receipt_no']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color:red;'>Student not found!</p>";
    }
}
?>