<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $description = $_POST['description'];

    // Fetch current amount for validation
    $categoryResult = mysqli_query($conn, "SELECT current_amount FROM categories WHERE id = '$category'");
    $categoryData = mysqli_fetch_assoc($categoryResult);
    $currentAmount = $categoryData['current_amount'];

    if ($amount > $currentAmount) {
        echo "Error: Expense exceeds the available category amount.";
        exit();
    }

    // Add expense
    $query = "INSERT INTO expenses (name, amount, date, description) VALUES ('$category', '$amount', '$date', '$description')";
    mysqli_query($conn, $query);

    // Deduct from category
    $newAmount = $currentAmount - $amount;
    mysqli_query($conn, "UPDATE categories SET current_amount = '$newAmount' WHERE id = '$category'");

    header('Location: expenses.php');
    exit();
}
?>
