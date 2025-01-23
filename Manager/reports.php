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

// Fetch category data
$categories_query = "SELECT category_name, allocated_amount, allocated_amount FROM categories";
$categories_result = mysqli_query($conn, $categories_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>



<body class="d-flex">
    <!-- Left Sidebar (Navigation) -->
    <div class="col-3 p-0">
        <?php include('includes/navigation.php'); ?>
    </div>

    <!-- Right Content -->
    <div class="col-9 p-4">
        <h2 class="text-center mb-4">Reports</h2>

        <!-- Summary Cards -->
        <div class="row">
            <div class="col-md-4">
                <div class="card text-bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Payments</h5>
                        <p class="card-text">Shs. <?php echo number_format($total_payments, 2); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Expenses</h5>
                        <p class="card-text">Shs. <?php echo number_format($total_expenses, 2); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Outstanding Balances</h5>
                        <p class="card-text">Shs. <?php echo number_format($outstanding_balances, 2); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="mb-5">
            <canvas id="paymentsExpensesChart"></canvas>
        </div>

        <!-- Category Details -->
        <h3 class="mb-3">Category Details</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Allocated Amount</th>
                    <th>Usage Progress</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($category = mysqli_fetch_assoc($categories_result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($category['category_name']); ?></td>
                        <td>Shs. <?php echo number_format($category['allocated_amount'], 2); ?></td>
                        <td>
                            <?php
                            $used_percentage = ($category['allocated_amount'] > 0)
                                ? (($category['allocated_amount'] - 0) / $category['allocated_amount']) * 100
                                : 0;
                            ?>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: <?php echo $used_percentage; ?>%;" aria-valuenow="<?php echo $used_percentage; ?>" aria-valuemin="0" aria-valuemax="100">
                                    <?php echo round($used_percentage, 2); ?>%
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const ctx = document.getElementById('paymentsExpensesChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Payments', 'Expenses'],
                datasets: [{
                    label: 'Amount in UGX',
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
    </script>
</body>
</html>
