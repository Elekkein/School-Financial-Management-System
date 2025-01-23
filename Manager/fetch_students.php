<?php
include('config.php');

if (isset($_GET['class'])) {
    $class = mysqli_real_escape_string($conn, $_GET['class']);

    $query = "SELECT id, name, fees FROM students WHERE class = '$class'";
    $result = mysqli_query($conn, $query);

    $students = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = $row;
    }

    echo json_encode($students);
}
?>
