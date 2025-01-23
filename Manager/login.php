<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'admin_system';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Query to check the username and password
    $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows === 1) {
        // Start session and redirect to admin dashboard
        session_start();
        $_SESSION['admin'] = $username;
        header('Location: dashboard.php');
        exit();
    } else {
        echo "<script>alert('Invalid username or password!');</script>";
    }
}
$conn->close();
?>
