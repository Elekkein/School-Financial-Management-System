
<?php
// Include the database connection
include 'config.php';

// Fetch total payments
$total_payments_query = "SELECT SUM(amount_paid) AS total_payments FROM payments";
$total_payments_result = mysqli_query($conn, $total_payments_query);
$total_payments = mysqli_fetch_assoc($total_payments_result)['total_payments'] ?? 0;

// Fetch total expenses
$total_expenses_query = "SELECT SUM(amount) AS total_expenses FROM expenses";
$total_expenses_result = mysqli_query($conn, $total_expenses_query);
$total_expenses = mysqli_fetch_assoc($total_expenses_result)['total_expenses'] ?? 0;

// Fetch total fees to pay
$total_fees_query = "SELECT SUM(fees) AS total_fees FROM students";
$total_fees_result = mysqli_query($conn, $total_fees_query);
$total_fees = mysqli_fetch_assoc($total_fees_result)['total_fees'] ?? 0;

// Calculate outstanding balances
$outstanding_balances = $total_fees - $total_payments;

// Fetch the number of students
$total_students_query = "SELECT COUNT(*) AS total_students FROM students";
$total_students_result = mysqli_query($conn, $total_students_query);
$total_students = mysqli_fetch_assoc($total_students_result)['total_students'] ?? 0;

// Fetch category data
$categories_query = "SELECT category_name, allocated_amount, current_amount FROM categories";
$categories_result = mysqli_query($conn, $categories_query);

// Prepare data for the pie chart
$category_labels = [];
$category_allocations = [];
while ($category = mysqli_fetch_assoc($categories_result)) {
    $category_labels[] = $category['category_name'];
    $category_allocations[] = $category['allocated_amount'];
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <style>
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transition: background-color 0.3s;
        }

        .card-title { font-size: 1.5rem; }
        .card { border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .chart-container { margin: auto; max-width: 600px; }


    </style>
</head>
<body class="d-flex">
    <!-- Left Sidebar (Navigation) -->
    <div class="col-3 p-0">
        <?php include('includes/navigation.php'); ?>
    </div>

    <!-- Right Content -->
    <div class="col-9 p-4">
        <div class="container mt-5">
        <h2 class="text-center mb-4">Dashboard Overview</h2>

        <!-- Summary Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="card text-bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Fees Collected</h5>
                        <p class="card-text">$<?php echo number_format($total_payments, 2); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Students</h5>
                        <p class="card-text"><?php echo $total_students; ?> Students</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Expenses</h5>
                        <p class="card-text">$<?php echo number_format($total_expenses, 2); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Outstanding Balances</h5>
                        <p class="card-text">$<?php echo number_format($outstanding_balances, 2); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row mt-5">
            <div class="col-md-6">
                <h4 class="text-center">Payments vs Expenses</h4>
                <canvas id="paymentsExpensesChart" class="chart-container"></canvas>
            </div>
            <div class="col-md-6">
                <h4 class="text-center">Category Allocations</h4>
                <canvas id="categoryChart" class="chart-container"></canvas>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Bar chart for Payments vs Expenses
        const paymentsExpensesCtx = document.getElementById('paymentsExpensesChart').getContext('2d');
        new Chart(paymentsExpensesCtx, {
            type: 'bar',
            data: {
                labels: ['Payments', 'Expenses'],
                datasets: [{
                    label: 'Amount in USD',
                    data: [<?php echo $total_payments; ?>, <?php echo $total_expenses; ?>],
                    backgroundColor: ['#28a745', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                }
            }
        });

        // Pie chart for Category Allocations
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($category_labels); ?>,
                datasets: [{
                    label: 'Category Allocations',
                    data: <?php echo json_encode($category_allocations); ?>,
                    backgroundColor: ['#007bff', '#ffc107', '#28a745', '#dc3545', '#6f42c1'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                }
            }
        });
    </script>
</body>
</html>