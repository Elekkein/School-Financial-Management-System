<?php
// logout.php

// Start the session
session_start();

// Destroy all session data to log out the user
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged Out</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="alert alert-success text-center">
            <h3>You have successfully logged out!</h3>
            <p>Click <a href="login.html" class="btn btn-primary">here</a> to go back to the login page.</p>
        </div>
    </div>
</body>
</html>
