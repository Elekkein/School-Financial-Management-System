<?php
// add_categories.php

// Include the database connection
include('config.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $percentage = mysqli_real_escape_string($conn, $_POST['percentage']);

    // Insert the data into the database
    $sql = "INSERT INTO categories (category_name, percentage) VALUES ('$category_name', '$percentage')";

    if (mysqli_query($conn, $sql)) {
        $success = "Category added successfully!";
    } else {
        $error = "Failed to add category. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
       <!-- Bootstrap Icons -->
       <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .form-container h2 {
            margin-bottom: 20px;
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
                    <div class="form-container">
                        <h2 class="text-center">Add Category</h2>
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success"><?= $success; ?></div>
                        <?php elseif (isset($error)): ?>
                            <div class="alert alert-danger"><?= $error; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter category name" required>
                            </div>
                            <div class="mb-3">
                                <label for="percentage" class="form-label">Percentage</label>
                                <input type="number" step="0.01" class="form-control" id="percentage" name="percentage" placeholder="Enter percentage (e.g., 20.00)" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Add Category</button>
                        </form>
                    </div>
                </div>


    </div>
        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
