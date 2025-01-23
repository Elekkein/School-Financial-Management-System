<?php
// teacher_section.php

// Include the database connection
include('config.php');

// Handle add teacher form submission
if (isset($_POST['add_teacher'])) {
    $teacher_name = mysqli_real_escape_string($conn, $_POST['teacher_name']);
    $subject_taught = mysqli_real_escape_string($conn, $_POST['subject_taught']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $responsibility = mysqli_real_escape_string($conn, $_POST['responsibility']);

    $sql = "INSERT INTO teachers (teacher_name, subject_taught, phone_number, responsibility)
            VALUES ('$teacher_name', '$subject_taught', '$phone_number', '$responsibility')";
    mysqli_query($conn, $sql);
}

// Fetch teachers from the database
$teachers = mysqli_query($conn, "SELECT * FROM teachers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
       <!-- Bootstrap Icons -->
       <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 40px;
        }
        .search-bar input {
            border-radius: 25px;
            padding: 10px 20px;
        }
        .btn-add {
            background-color: #007bff;
            color: #fff;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 16px;
        }
        .btn-add:hover {
            background-color: #0056b3;
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
        .table td {
            vertical-align: middle;
        }
        .modal-header {
            background-color: #007bff;
            color: white;
        }
        .modal-header h5 {
            margin: 0;
        }
        .modal-footer button {
            border-radius: 25px;
        }
        .fa-user-plus {
            margin-right: 5px;
        }
    </style>
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
        <h2 class="text-center text-primary mb-4">Teachers Management</h2>
        
        <!-- Add Teacher Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="search-bar w-50">
                <input type="text" id="searchInput" class="form-control" placeholder="Search by teacher name...">
            </div>
            <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                <i class="fas fa-user-plus"></i> Add Teacher
            </button>
        </div>

        <!-- Teachers Table -->
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Subject Taught</th>
                        <th>Phone Number</th>
                        <th>Responsibility</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; while ($row = mysqli_fetch_assoc($teachers)): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= htmlspecialchars($row['teacher_name']); ?></td>
                        <td><?= htmlspecialchars($row['subject_taught']); ?></td>
                        <td><?= htmlspecialchars($row['phone_number']); ?></td>
                        <td><?= htmlspecialchars($row['responsibility']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Adding Teacher -->
    <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTeacherModalLabel">Add New Teacher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="teacher_name" class="form-label">Teacher Name</label>
                            <input type="text" class="form-control" id="teacher_name" name="teacher_name" placeholder="Enter full name" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject_taught" class="form-label">Subject Taught</label>
                            <input type="text" class="form-control" id="subject_taught" name="subject_taught" placeholder="Enter subject taught" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter phone number" required>
                        </div>
                        <div class="mb-3">
                            <label for="responsibility" class="form-label">Responsibility</label>
                            <input type="text" class="form-control" id="responsibility" name="responsibility" placeholder="Enter responsibility (e.g., Class Teacher)">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="add_teacher">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



             </div>
             <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Real-time search functionality
        const searchInput = document.getElementById('searchInput');
        const teachersTable = document.querySelector('.table tbody');

        searchInput.addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            Array.from(teachersTable.rows).forEach(row => {
                const teacherName = row.cells[1].textContent.toLowerCase();
                row.style.display = teacherName.includes(filter) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
