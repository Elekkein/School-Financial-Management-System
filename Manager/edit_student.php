<?php
// edit_student.php

// Include the database connection file
include('config.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect data from the form
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $class = mysqli_real_escape_string($conn, $_POST['class']);
    $parent_name = mysqli_real_escape_string($conn, $_POST['parent_name']);
    $parent_phone = mysqli_real_escape_string($conn, $_POST['parent_phone']);
    $fees = mysqli_real_escape_string($conn, $_POST['fees']);

    // Update the record in the database
    $sql = "UPDATE students 
            SET name = '$name', class = '$class', parent_name = '$parent_name', parent_phone = '$parent_phone', fees = '$fees' 
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        // Redirect back to the students information page with a success message
        header("Location: student_information.php");
        exit();
    } else {
        // Redirect back with an error message
        header("Location: student_information.php?error=1");
        exit();
    }
}
?>
