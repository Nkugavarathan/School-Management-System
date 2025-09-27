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

<form method="post">
    <label>Student ID:</label>
    <input type="number" name="student_id" required><br>
    <label>Due Amount:</label>
    <input type="number" step="0.01" name="due_amount" required><br>
    <label>Due Date:</label>
    <input type="date" name="due_date" required><br>
    <button type="submit">Add Fee</button>
</form>