<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_expense'])) {
    $category_id = $_POST['category_id'];
    $amount = (float)$_POST['amount'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Fetch current allocated amount for the selected category
    $query = "SELECT allocated_amount FROM categories WHERE id = $category_id";
    $result = mysqli_query($conn, $query);
    $category = mysqli_fetch_assoc($result);

    if ($category) {
        $allocated_amount = (float)$category['allocated_amount'];

        // Check if the expense exceeds the allocated amount
        if ($amount > $allocated_amount) {
            echo "<script>alert('Expense exceeds the allocated amount for this category!');</script>";
        } else {
            // Insert the expense into the expenses table
            $insertExpense = "INSERT INTO expenses (id, amount, description) VALUES ($category_id, $amount, '$description')";
            if (mysqli_query($conn, $insertExpense)) {
                // Update the category's allocated amount
                $new_allocated_amount = $allocated_amount - $amount;
                $updateCategory = "UPDATE categories SET allocated_amount = $new_allocated_amount WHERE id = $category_id";
                mysqli_query($conn, $updateCategory);

                echo "<script>alert('Expense added successfully!');</script>";
            } else {
                echo "<script>alert('Error adding expense: " . mysqli_error($conn) . "');</script>";
            }
        }
    }
}

// Fetch all categories
$categoriesResult = mysqli_query($conn, "SELECT id, category_name, allocated_amount FROM categories");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
           <!-- Bootstrap Icons -->
           <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>


<body class="d-flex">



    <!-- Left Sidebar (Navigation) -->
    <div class="col-3 p-0">
        <?php include('includes/navigation.php'); ?>
    </div>

    <!-- Right Content -->
    <div class="col-9 p-4">
                    <div class="container mt-5">
                        <h2 class="mb-4">Add Expense</h2>

                        <form method="POST" class="mb-4">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select name="category_id" id="category_id" class="form-select" required>
                                        <option value="" disabled selected>Select a category</option>
                                        <?php while ($category = mysqli_fetch_assoc($categoriesResult)) { ?>
                                            <option value="<?php echo $category['id']; ?>">
                                                <?php echo $category['category_name'] . " (Allocated: " . $category['allocated_amount'] . ")"; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" name="amount" id="amount" class="form-control" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="description" class="form-label">Description</label>
                                    <input type="text" name="description" id="description" class="form-control">
                                </div>
                            </div>

                            <button type="submit" name="add_expense" class="btn btn-primary">Add Expense</button>
                        </form>

                        <h3>Expenses</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $expensesResult = mysqli_query($conn, "
                                    SELECT expenses.id, categories.category_name AS category_name, expenses.amount, expenses.description, expenses.created_at 
                                    FROM expenses 
                                    JOIN categories ON expenses.id = categories.id
                                ");

                                while ($expense = mysqli_fetch_assoc($expensesResult)) { ?>
                                    <tr>
                                        <td><?php echo $expense['id']; ?></td>
                                        <td><?php echo $expense['category_name']; ?></td>
                                        <td><?php echo $expense['amount']; ?></td>
                                        <td><?php echo $expense['description']; ?></td>
                                        <td><?php echo $expense['created_at']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>


           </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
