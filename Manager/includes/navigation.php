<?php
// navigation.php
?>
<nav class="d-flex flex-column justify-content-between bg-primary text-white vh-100 p-3" style="width: 250px;">
    <div class="mb-5">
        <!-- Logo or Dashboard Title -->
        <h3 class="text-center mb-4">
            <i class="bi bi-house-door-door text-light"></i> Dashboard
        </h3>
        <ul class="nav flex-column">
            <!-- Overview Item -->
            <li class="nav-item mb-3">
                <a class="nav-link text-white d-flex align-items-center" href="dashboard.php">
                    <i class="bi bi-house-door me-3"></i> Overview
                </a>
            </li>

            <!-- Students Section with Subsets -->
            <li class="nav-item mb-3">
                <a class="nav-link text-white d-flex align-items-center" href="#" data-bs-toggle="collapse" data-bs-target="#studentsSubMenu" aria-expanded="false" aria-controls="studentsSubMenu">
                    <i class="bi bi-person-lines-fill me-3"></i> Students
                </a>
                <ul class="collapse" id="studentsSubMenu">
                    <li><a class="nav-link text-white ms-3" href="add_student.php"><i class="bi bi-person-plus-fill me-2"></i> Add Student</a></li>
                    <li><a class="nav-link text-white ms-3" href="student_information.php"><i class="bi bi-person-badge me-2"></i> Students Information</a></li>
                </ul>
            </li>

            <!-- Finances Section with Subsets -->
            <li class="nav-item mb-3">
                <a class="nav-link text-white d-flex align-items-center" href="#" data-bs-toggle="collapse" data-bs-target="#financesSubMenu" aria-expanded="false" aria-controls="financesSubMenu">
                    <i class="bi bi-wallet me-3"></i> Finances
                </a>
                <ul class="collapse" id="financesSubMenu">
                    <li><a class="nav-link text-white ms-3" href="overview.php"><i class="bi bi-bar-chart-line me-2"></i> Overview</a></li>
                    <li><a class="nav-link text-white ms-3" href="add_payment.php"><i class="bi bi-credit-card me-2"></i> Add Payment</a></li>
                    <li><a class="nav-link text-white ms-3" href="balances.php"><i class="bi bi-wallet2 me-2"></i> Balances</a></li>
                    <li><a class="nav-link text-white ms-3" href="payment_history.php"><i class="bi bi-clock me-2"></i> Payment History</a></li>
                </ul>
            </li>

            <!-- Expenses -->
            <li class="nav-item mb-3">
                <a class="nav-link text-white d-flex align-items-center" href="expense.php">
                    <i class="bi bi-coin me-3"></i> Expenses
                </a>
            </li>

            <!-- Categories -->
            <li class="nav-item mb-3">
                <a class="nav-link text-white d-flex align-items-center" href="#" data-bs-toggle="collapse" data-bs-target="#sectors" aria-expanded="false" aria-controls="financesSubMenu">
                    <i class="bi bi-wallet me-3"></i> Sectors
                </a>
                <ul class="collapse" id="sectors">
                    <li><a class="nav-link text-white ms-3" href="add_sector.php"><i class="bi bi-bar-chart-line me-2"></i> Add sector</a></li>
                    <li><a class="nav-link text-white ms-3" href="sector_details.php"><i class="bi bi-credit-card me-2"></i> Sector details</a></li>
                    
                </ul>
            </li>

            <!-- Reports -->
            <li class="nav-item mb-3">
                <a class="nav-link text-white d-flex align-items-center" href="reports.php">
                    <i class="bi bi-file-earmark-bar-graph me-3"></i> Reports
                </a>
            </li>

            <!-- Teachers -->
            <li class="nav-item mb-3">
                <a class="nav-link text-white d-flex align-items-center" href="teachers.php">
                    <i class="bi bi-person-workspace me-3"></i> Teachers
                </a>
            </li>

            <!-- Logout -->
            <li class="nav-item mb-3">
                <a class="nav-link text-white d-flex align-items-center" href="logout.php">
                    <i class="bi bi-box-arrow-right me-3"></i> Logout
                </a>
            </li>
        </ul>
    </div>
    <footer class="text-center text-white mt-auto">
        <small>&copy; 2025 Your Company</small>
    </footer>
</nav>
