<?php
include('config.php');


// Fetch student balances from the database
$query = "
    SELECT 
        s.id AS student_id, 
        s.name AS student_name, 
        s.class, 
        COALESCE(SUM(p.amount_paid), 0) AS paid_fees, 
        (s.fees - COALESCE(SUM(p.amount_paid), 0)) AS remaining_balance 
    FROM 
        students s 
    LEFT JOIN 
        payments p 
    ON 
        s.id = p.student_id 
    GROUP BY 
        s.id, s.name, s.class, s.fees
";
$result = mysqli_query($conn, $query);
$students = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balances</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Font Awesome -->
       <!-- Bootstrap Icons -->
       <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
        }
        .container {
            margin-top: 40px;
        }
        .btn-print {
            background-color: #007bff;
            color: #fff;
            border-radius: 25px;
        }
        .btn-print:hover {
            background-color: #0056b3;
        }
        .search-bar {
            margin-bottom: 20px;
        }
        table {
            background: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>



<body class="d-flex">

    <!-- Left Sidebar (Navigation) -->
    <div class="col-3 p-0">
        <?php include('includes/navigation.php'); ?>
    </div>

    <!-- Right Content -->
    <div class="col-9 p-4">

            <div class="container">
                <h2 class="text-center text-primary mb-4">Student Balances</h2>
                
                <!-- Search Bar -->
                <input 
                    type="text" 
                    class="form-control search-bar" 
                    id="searchInput" 
                    placeholder="Search for a student..." 
                    onkeyup="filterTable()">

                <!-- Balances Table -->
                <table class="table table-bordered table-hover text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Class</th>
                            <th>Paid Fees</th>
                            <th>Remaining Balance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="balancesTable">
                        <?php foreach ($students as $index => $student): ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= $student['student_name']; ?></td>
                            <td><?= $student['class']; ?></td>
                            <td>Shs. <?= number_format($student['paid_fees'], 2); ?></td>
                            <td>Shs. <?= number_format($student['remaining_balance'], 2); ?></td>
                            <td>
                            <a 
                                href="receipt_template.php?student_id=<?= $student['student_id']; ?>" 
                                class="btn btn-outline-primary">
                                <i class="fas fa-print"></i> Print
                            </a>

                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Print All Receipts Button -->
                <div class="text-end">
                    <a href="print_all_receipts.php" class="btn btn-print">
                        <i class="fas fa-print"></i> Print All Receipts
                    </a>
                </div>
            </div>


     </div>

    <script>
        function filterTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const tableRows = document.getElementById('balancesTable').getElementsByTagName('tr');

            for (let i = 0; i < tableRows.length; i++) {
                const rowText = tableRows[i].innerText.toLowerCase();
                tableRows[i].style.display = rowText.includes(searchInput) ? '' : 'none';
            }
        }
    </script>
</body>
</html>
