<?php
include('config.php');

if (isset($_POST['make_payment'])) {
    $student_id = $_POST['student_id'];
    $amount_paid = $_POST['amount_paid'];

    // Fetch categories for allocation
    $categories = mysqli_query($conn, "SELECT id, percentage FROM categories");

    // Allocate payment
    while ($category = mysqli_fetch_assoc($categories)) {
        $category_id = $category['id'];
        $percentage = $category['percentage'];
        $allocated_amount = ($amount_paid * $percentage) / 100;

        mysqli_query($conn, "UPDATE categories SET allocated_amount = allocated_amount + $allocated_amount WHERE id = '$category_id'");
    }

    // Insert payment record
    $query = "INSERT INTO payments (student_id, amount_paid) VALUES ('$student_id', '$amount_paid')";
    mysqli_query($conn, $query);

    header('Location: add_payment.php?success=1');
    exit;
}
?>
