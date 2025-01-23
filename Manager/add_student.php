<?php
// add_student.php

// Include your database connection file (update the path as needed)
include('config.php'); // Assuming you have a 'config.php' for DB connection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $name = $_POST['name'];
    $class = $_POST['class'];
    $fees = $_POST['fees'];
    $parent_name = $_POST['parent_name'];
    $parent_phone = $_POST['parent_phone'];
    $dob = $_POST['dob'];
    $residence = $_POST['residence'];
    $village = $_POST['village'];

    // Insert the data into the database
    $sql = "INSERT INTO students (name, class, fees, parent_name, parent_phone, dob, residence, village)
            VALUES ('$name', '$class', '$fees', '$parent_name', '$parent_phone', '$dob', '$residence', '$village')";
    
    if (mysqli_query($conn, $sql)) {
        echo '<div class="alert alert-success">Student added successfully!</div>';
    } else {
        echo '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h3>Add New Student</h3>
                    </div>
                    <div class="card-body">
                        <form id="addStudentForm" action="add_student.php" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Student Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter student's full name" required>
                                </div>
                                <small class="text-danger" id="nameError"></small>
                            </div>
                            <div class="mb-3">
                                <label for="class" class="form-label">Class <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-school"></i></span>
                                    <select class="form-select" id="class" name="class" required>
                                        <option value="">Select Class</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                        <option value="S4">S4</option>
                                        <option value="S5">S5</option>
                                        <option value="S6">S6</option>
                                    </select>
                                </div>
                                <small class="text-danger" id="classError"></small>
                            </div>
                            <div class="mb-3">
                                <label for="fees" class="form-label">Fees to Pay <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-money-bill"></i></span>
                                    <input type="number" class="form-control" id="fees" name="fees" placeholder="Enter fees amount" required>
                                </div>
                                <small class="text-danger" id="feesError"></small>
                            </div>
                            <div class="mb-3">
                                <label for="parent_name" class="form-label">Parent's Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                    <input type="text" class="form-control" id="parent_name" name="parent_name" placeholder="Enter parent's name" required>
                                </div>
                                <small class="text-danger" id="parentNameError"></small>
                            </div>
                            <div class="mb-3">
                                <label for="parent_phone" class="form-label">Parent's Phone Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="form-control" id="parent_phone" name="parent_phone" placeholder="Enter parent's phone number" required>
                                </div>
                                <small class="text-danger" id="parentPhoneError"></small>
                            </div>
                            <div class="mb-3">
                                <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" class="form-control" id="dob" name="dob" required>
                                </div>
                                <small class="text-danger" id="dobError"></small>
                            </div>
                            <div class="mb-3">
                                <label for="residence" class="form-label">Residence <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                                    <input type="text" class="form-control" id="residence" name="residence" placeholder="Enter residence area" required>
                                </div>
                                <small class="text-danger" id="residenceError"></small>
                            </div>
                            <div class="mb-3">
                                <label for="village" class="form-label">Village <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="text" class="form-control" id="village" name="village" placeholder="Enter village name" required>
                                </div>
                                <small class="text-danger" id="villageError"></small>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary px-4">Add Student</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>                
    </div>

    <!-- Bootstrap JS (Optional, for responsive features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="includes/scripts.js"></script>



</body>
</html>



