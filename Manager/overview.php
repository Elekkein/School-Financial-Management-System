<?php
include('config.php');

// Query to fetch total amount paid by students
$total_paid_query = "SELECT SUM(amount_paid) AS total_paid FROM payments";
$total_paid_result = mysqli_query($conn, $total_paid_query);
$total_paid_row = mysqli_fetch_assoc($total_paid_result);
$total_paid = $total_paid_row['total_paid'];

// Query to fetch total fees to be paid (using the 'fees' column)
$total_fees_query = "SELECT SUM(fees) AS total_fees FROM students";
$total_fees_result = mysqli_query($conn, $total_fees_query);
$total_fees_row = mysqli_fetch_assoc($total_fees_result);
$total_fees = $total_fees_row['total_fees'];

// Calculate total remaining balance
$total_remaining = $total_fees - $total_paid;

// Query to fetch the total amount allocated to each category
$category_query = "SELECT category_name, SUM(allocated_amount) AS total_in_category FROM categories GROUP BY category_name";
$category_result = mysqli_query($conn, $category_query);

// Fetch all categories' total amounts into an array
$categories = [];
while ($row = mysqli_fetch_assoc($category_result)) {
    $categories[$row['category_name']] = $row['total_in_category'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finances Overview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            margin-top: 20px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .summary-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .summary-card h5 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .summary-card .value {
            font-size: 30px;
            font-weight: bold;
        }

        .category-summary {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .category-summary h5 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .category-summary .category-item {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .progress-bar-container {
            margin-top: 20px;
        }

        .progress-bar-container .progress {
            height: 30px;
            border-radius: 10px;
        }

        .progress-container-text {
            font-size: 18px;
            margin-top: 10px;
            font-weight: bold;
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

                    <!-- Total Summary Section -->
                    <div class="summary-card">
                        <h5>Total Amount Paid So Far</h5>
                        <div class="value">Shs. <?php echo number_format($total_paid, 2); ?></div>

                        <!-- Progress bar showing total payments -->
                        <div class="progress-bar-container">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: <?php echo ($total_paid / $total_fees) * 100; ?>%" aria-valuenow="<?php echo ($total_paid / $total_fees) * 100; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="progress-container-text">Progress: <?php echo number_format(($total_paid / $total_fees) * 100, 2); ?>%</div>
                        </div>
                    </div>

                    <div class="summary-card">
                        <h5>Total Remaining Balance</h5>
                        <div class="value">Shs. <?php echo number_format($total_remaining, 2); ?></div>

                        <!-- Progress bar showing remaining balance -->
                        <div class="progress-bar-container">
                            <div class="progress">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo ($total_remaining / $total_fees) * 100; ?>%" aria-valuenow="<?php echo ($total_remaining / $total_fees) * 100; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="progress-container-text">Remaining: <?php echo number_format(($total_remaining / $total_fees) * 100, 2); ?>%</div>
                        </div>
                    </div>

                    <!-- Category Breakdown Section -->
                    <div class="category-summary">
                        <h5>Total Amount in Each Category</h5>
                        <?php
                        if (empty($categories)) {
                            echo "<p>No category allocation found.</p>";
                        } else {
                            foreach ($categories as $category => $amount) {
                                echo "<div class='category-item'>{$category}: <strong>Shs. " . number_format($amount, 2) . "</strong></div>";
                            }
                        }
                        ?>
                    </div>

                </div>



      </div>


      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-QFfYuwXfG5WbIVDo7y7NUhJnxirHXbFLYzg1ZLU4EzGkOuyrsBJPeq0F7MKlsyK2G" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76A21E6Xp0fHrKOOpgzWNYAUmHvnOp2RrZjx0g13E23Xj/n2c2H9jjp92KAjcXa" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+5hb7xB5vZG5szLvIDOk2kjmDPg0fAPi2tJQX1F" crossorigin="anonymous"></script>




</body>
</html>
