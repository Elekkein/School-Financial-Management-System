<?php
// config.php

// Database connection variables
$servername = "localhost"; // or your server name if remote
$username = "root"; // Your database username (e.g., 'root')
$password = ""; // Your database password (use a password if required)
$dbname = "admin_system"; // The name of your database

// Create a connection using MySQLi
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    // If the connection fails, stop the script and show the error message
    die("Connection failed: " . mysqli_connect_error());
}

// Optionally, set the character set for the connection
mysqli_set_charset($conn, 'utf8');

// Connection successful, return the connection object
// You can now use `$conn` in other files to interact with the database
?>
