<?php
// students_information.php

// Include your database connection file
include('config.php');

// Handle delete request
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql = "DELETE FROM students WHERE id = $delete_id";
    mysqli_query($conn, $sql);
}

// Fetch students from the database
$students = mysqli_query($conn, "SELECT * FROM students");
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Font Awesome -->
       <!-- Bootstrap Icons -->
       <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
        .search-bar {
            margin-bottom: 20px;
        }
        .modal-header {
            background-color: #0d6efd;
            color: white;
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
                <h2 class="text-center mb-4">Students Information</h2>
                <div class="search-bar">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search by student name...">
                </div>
                <table class="table table-hover table-bordered table-striped" id="studentsTable">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Class</th>
                            <th>Parent Name</th>
                            <th>Phone Number</th>
                            <th>Fees</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; while ($row = mysqli_fetch_assoc($students)): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['class']); ?></td>
                            <td><?= htmlspecialchars($row['parent_name']); ?></td>
                            <td><?= htmlspecialchars($row['parent_phone']); ?></td>
                            <td><?= htmlspecialchars($row['fees']); ?></td>
                            <td>
                                <button class="btn btn-success btn-sm editBtn" 
                                    data-id="<?= $row['id']; ?>" 
                                    data-name="<?= htmlspecialchars($row['name']); ?>" 
                                    data-class="<?= htmlspecialchars($row['class']); ?>" 
                                    data-parent="<?= htmlspecialchars($row['parent_name']); ?>" 
                                    data-phone="<?= htmlspecialchars($row['parent_phone']); ?>" 
                                    data-fees="<?= htmlspecialchars($row['fees']); ?>">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?= $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Student Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" method="POST" action="edit_student.php">
                                <input type="hidden" id="edit_id" name="id">
                                <div class="mb-3">
                                    <label for="edit_name" class="form-label">Student Name</label>
                                    <input type="text" class="form-control" id="edit_name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_class" class="form-label">Class</label>
                                    <select class="form-select" id="edit_class" name="class" required>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                        <option value="S4">S4</option>
                                        <option value="S5">S5</option>
                                        <option value="S6">S6</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_parent" class="form-label">Parent Name</label>
                                    <input type="text" class="form-control" id="edit_parent" name="parent_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="edit_phone" name="parent_phone" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_fees" class="form-label">Fees</label>
                                    <input type="number" class="form-control" id="edit_fees" name="fees" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


     </div>









    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const searchInput = document.getElementById('searchInput');
        const studentsTable = document.getElementById('studentsTable').getElementsByTagName('tbody')[0];
        const editModal = new bootstrap.Modal(document.getElementById('editModal'));

        // Search functionality
        searchInput.addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            Array.from(studentsTable.rows).forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                row.style.display = name.includes(filter) ? '' : 'none';
            });
        });

        // Edit button functionality
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('edit_id').value = this.dataset.id;
                document.getElementById('edit_name').value = this.dataset.name;
                document.getElementById('edit_class').value = this.dataset.class;
                document.getElementById('edit_parent').value = this.dataset.parent;
                document.getElementById('edit_phone').value = this.dataset.phone;
                document.getElementById('edit_fees').value = this.dataset.fees;
                editModal.show();
            });
        });
    </script>
</body>
</html>
