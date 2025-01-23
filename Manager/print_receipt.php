<?php
include('config.php');

if (isset($_GET['student_id'])) {
    $student_id = intval($_GET['student_id']);

    // Fetch student details
    $query = "
        SELECT 
            s.name AS student_name, 
            s.class, 
            s.fees, 
            COALESCE(SUM(p.amount_paid), 0) AS paid_fees, 
            (s.fees - COALESCE(SUM(p.amount_paid), 0)) AS remaining_balance 
        FROM 
            students s 
        LEFT JOIN 
            payments p 
        ON 
            s.id = p.student_id 
        WHERE 
            s.id = '$student_id' 
        GROUP BY 
            s.id, s.name, s.class, s.fees
    ";
    $result = mysqli_query($conn, $query);
    $student = mysqli_fetch_assoc($result);

    if ($student) {
        echo "
        <h1>Receipt</h1>
        <p><strong>Name:</strong> {$student['student_name']}</p>
        <p><strong>Class:</strong> {$student['class']}</p>
        <p><strong>Paid Fees:</strong> $ {$student['paid_fees']}</p>
        <p><strong>Remaining Balance:</strong> $ {$student['remaining_balance']}</p>
        ";
    } else {
        echo "<p>Student not found.</p>";
    }
}
?>
