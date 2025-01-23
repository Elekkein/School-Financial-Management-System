<?php
include('config.php');

// Ensure the student ID is provided
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

    if (!$student) {
        die("<p>Student not found.</p>");
    }
} else {
    die("<p>Invalid access. No student selected.</p>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        .receipt-container {
            border: 2px solid #000;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            background: #f5f5f5;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt-header img {
            width: 80px;
            height: auto;
        }
        .receipt-header h1 {
            font-size: 24px;
            margin: 10px 0;
        }
        .receipt-header p {
            margin: 0;
        }
        .receipt-details {
            margin-bottom: 20px;
        }
        .receipt-details p {
            margin: 5px 0;
        }
        .receipt-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        .receipt-footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- School Information -->
        <div class="receipt-header">
            <img src="logo.png" alt="School Logo" class="w-50 p-3">
            <h1>TIMBITWIRE GIRLS' SCHOOL</h1>
            <p>Address: P.O.BOX 1102 Bushenyi</p>
            <p>Contact: +256 777372229 | Email: timbitwire.girls@yahoo.com</p>
        </div>

        <!-- Student Details -->
        <div class="receipt-details">
            <h3>Payment Receipt</h3>
            <p><strong>Name:</strong> <?= $student['student_name']; ?></p>
            <p><strong>Class:</strong> <?= $student['class']; ?></p>
            <p><strong>Total Fees:</strong> Shs. <?= number_format($student['fees'], 2); ?></p>
            <p><strong>Paid Fees:</strong> Shs. <?= number_format($student['paid_fees'], 2); ?></p>
            <p><strong>Remaining Balance:</strong> Shs. <?= number_format($student['remaining_balance'], 2); ?></p>
        </div>

        <!-- Footer -->
        <div class="receipt-footer">
            <p>Thank you for your payment!</p>
            <p>Issued on: <?= date('Y-m-d H:i:s'); ?></p>
        </div>
    </div>
</body>
</html>
