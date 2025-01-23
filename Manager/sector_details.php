<?php
// sector_details.php

// Include the database connection
include('config.php');

// Handle delete request
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql = "DELETE FROM categories WHERE id = $delete_id";
    mysqli_query($conn, $sql);
}

// Handle edit form submission
if (isset($_POST['update_id'])) {
    $update_id = $_POST['update_id'];
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $percentage = mysqli_real_escape_string($conn, $_POST['percentage']);

    $sql = "UPDATE categories SET category_name = '$category_name', percentage = '$percentage' WHERE id = $update_id";
    mysqli_query($conn, $sql);
}

// Fetch sectors from the database
$sectors = mysqli_query($conn, "SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sector Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
                    <h2 class="text-center mb-4">Sector Details</h2>
                    
                    <!-- Success or Error Message -->
                    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Sector deleted successfully!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php elseif (isset($_GET['error']) && $_GET['error'] == 1): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Failed to delete sector. Please try again.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Search Bar -->
                    <div class="search-bar">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search sectors...">
                    </div>

                    <!-- Table displaying sectors -->
                    <table class="table table-hover table-bordered table-striped" id="sectorsTable">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Sector Name</th>
                                <th>Percentage Allocations</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; while ($row = mysqli_fetch_assoc($sectors)): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= htmlspecialchars($row['category_name']); ?></td>
                                <td><?= htmlspecialchars($row['percentage']); ?></td>
                                <td>
                                    <!-- Edit Sector Button (Triggers Modal) -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id']; ?>">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    
                                    <!-- Delete Sector Form -->
                                    <form method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="delete_id" value="<?= $row['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this sector?');">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            
                            <!-- Edit Sector Modal -->
                            <div class="modal fade" id="editModal<?= $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Sector</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="sector_name" class="form-label">Sector Name</label>
                                                    <input type="text" class="form-control" id="category_name" name="category_name" value="<?= htmlspecialchars($row['category_name']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Percentage Allocation</label>
                                                    <textarea class="form-control" id="percentage" name="percentage" rows="3" required><?= htmlspecialchars($row['percentage']); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" name="update_id" value="<?= $row['id']; ?>">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>


     </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const sectorsTable = document.getElementById('sectorsTable').getElementsByTagName('tbody')[0];

        searchInput.addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            Array.from(sectorsTable.rows).forEach(row => {
                const sectorName = row.cells[1].textContent.toLowerCase();
                row.style.display = sectorName.includes(filter) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
