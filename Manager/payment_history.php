<?php
include('config.php');

// Fetch payment history data
$query = "
    SELECT 
        s.name AS student_name, 
        p.amount_paid, 
        p.payment_date 
    FROM 
        payments p 
    JOIN 
        students s 
    ON 
        p.student_id = s.id 
    ORDER BY 
        p.payment_date DESC
";
$result = mysqli_query($conn, $query);

// Check if there are any payments
if (mysqli_num_rows($result) == 0) {
    $no_data = true;
} else {
    $no_data = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
        /* Main Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f9fc;
            margin-top: 20px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        /* Search Bar */
        .search-bar {
            width: 100%;
            max-width: 400px;
            margin-bottom: 30px;
        }

        .search-bar input {
            height: 40px;
            border-radius: 25px;
            padding-left: 20px;
            font-size: 16px;
        }

        /* Table Styling */
        .table-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #007bff;
            color: white;
        }

        th, td {
            padding: 15px;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #e9ecef;
            cursor: pointer;
        }

        .no-data {
            text-align: center;
            font-size: 18px;
            color: #999;
            padding: 30px 0;
        }

        /* Print Button Styling */
        .btn-print {
            background-color: #28a745;
            color: white;
            border-radius: 25px;
            padding: 12px 20px;
            text-align: center;
            font-size: 16px;
            margin-top: 30px;
        }

        .btn-print:hover {
            background-color: #218838;
            text-decoration: none;
        }

        .btn-print i {
            margin-right: 10px;
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
                    <!-- Search Bar -->
                    <div class="search-bar">
                        <input type="text" class="form-control" id="search-bar" placeholder="Search for a student...">
                    </div>

                    <!-- Table for Payment History -->
                    <div class="table-container">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Amount Paid</th>
                                    <th>Payment Date</th>
                                </tr>
                            </thead>
                            <tbody id="payment-history-table">
                                <?php
                                if (!$no_data) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "
                                        <tr>
                                            <td>{$row['student_name']}</td>
                                            <td>\${$row['amount_paid']}</td>
                                            <td>{$row['payment_date']}</td>
                                        </tr>
                                        ";
                                    }
                                } else {
                                    echo "<tr class='no-data'><td colspan='3'>No payment records found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Print Button -->
                    <a href="print_all_receipts.php" class="btn btn-print">
                        <i class="fas fa-print"></i> Print All Receipts
                    </a>
                </div>

     </div>


    <script>
        // Implement search functionality
        document.getElementById('search-bar').addEventListener('input', function() {
            var searchText = this.value.toLowerCase();
            var rows = document.querySelectorAll('#payment-history-table tr');
            rows.forEach(row => {
                var studentName = row.cells[0].textContent.toLowerCase();
                if (studentName.indexOf(searchText) !== -1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
