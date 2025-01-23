<?php
include('config.php');

// Fetch available classes
$classes = ['S1', 'S2', 'S3', 'S4', 'S5', 'S6'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
       <!-- Bootstrap Icons -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f5f7fa;
        }
        .container {
            margin-top: 40px;
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-submit {
            background-color: #007bff;
            color: #fff;
            border-radius: 25px;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
        .warning {
            color: red;
            font-weight: bold;
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
                        <h2 class="text-center text-primary mb-4">Add Payment</h2>
                        <form method="POST" action="process_payment.php">
                            <div class="mb-3">
                                <label for="class" class="form-label">Select Class</label>
                                <select class="form-control" id="class" name="class" onchange="fetchStudents()" required>
                                    <option value="">Select a class</option>
                                    <?php foreach ($classes as $class): ?>
                                        <option value="<?= $class; ?>"><?= $class; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="student_id" class="form-label">Student Name</label>
                                <select class="form-control" id="student_id" name="student_id" onchange="fetchFees()" required>
                                    <option value="">Select a student</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="fees_due" class="form-label">Fees Due</label>
                                <input type="text" class="form-control" id="fees_due" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="amount_paid" class="form-label">Amount Paid</label>
                                <input type="number" class="form-control" id="amount_paid" name="amount_paid" required>
                                <small id="warning" class="warning"></small>
                            </div>
                            <button type="submit" class="btn btn-submit" name="make_payment">Make Payment</button>
                        </form>
                    </div>


    </div>

    <script>
        function fetchStudents() {
            const classSelected = document.getElementById('class').value;
            const studentDropdown = document.getElementById('student_id');
            
            if (classSelected) {
                fetch(`fetch_students.php?class=${classSelected}`)
                    .then(response => response.json())
                    .then(data => {
                        studentDropdown.innerHTML = '<option value="">Select a student</option>';
                        data.forEach(student => {
                            studentDropdown.innerHTML += `<option value="${student.id}" data-fees="${student.fees}">${student.name}</option>`;
                        });
                    });
            } else {
                studentDropdown.innerHTML = '<option value="">Select a student</option>';
            }
        }

        function fetchFees() {
            const studentDropdown = document.getElementById('student_id');
            const feesDueInput = document.getElementById('fees_due');
            const selectedOption = studentDropdown.options[studentDropdown.selectedIndex];
            const feesDue = selectedOption.getAttribute('data-fees');
            feesDueInput.value = feesDue || '';
        }
    </script>
</body>
</html>
