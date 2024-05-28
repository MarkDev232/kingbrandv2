<?php
include "connect.php";
session_start();
if (!isset($_SESSION['auth_admin']['adminFullName'])) {
    // If not logged in, redirect to the login page
    echo "<script> alert('Please Login First');
        location.href='sign_in.php';</script>";
    exit();
}

// Get current month, day, and year
$month = date('m');
$day = date('d');
$year = date('Y');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Jersey Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/main.css">
    <style>
        /* Adjustments for sidebar */
        .sidebar {
            position: fixed;
            top: 50px;
            left: 0;
            height: 100%;
            width: 300px;
            /* Increased width */
            padding-top: 3.5rem;
            padding-bottom: 1rem;
            /* Added padding bottom */
            background-color: #343a40;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar .nav-link{
            color: rgba(255, 255, 255, 0.5);
        }

        .sidebar .nav-link:hover {
            color: white;
        }

        .main-content {
            margin-left: 250px;
            /* Adjusted margin-left to match sidebar width */
            padding-top: 3.5rem;
            /* Added padding-top to match navbar height */
            padding-left: 1rem;
            /* Added padding-left for content separation */
        }

        .sidebar .nav-link:active {
            color: white;
        }
        .dropdown-menu{
            background-color: #343a40;
        }
        .dropdown-item{
            color: rgba(255, 255, 255, 0.5);
        }
        .dropdown-item:hover{
            color:white;
            background-color: #343a40;
        }

        /* Custom styles for header and title */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        .title {
            text-align: center;
            margin-top: 80px;
            margin-bottom: 30px;
            font-size: 28px;
        }
    </style>
</head>

<body>
<?php
    include('header.php');
    ?>

<!-- Sidebar -->
<div class="sidebar" style="width: 250px;">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="admin.php"><i class="fa fa-dashboard"></i> Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="admin_user.php"><i class="fa fa-user"></i> Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="admin_user_block.php"><i class="fa fa-user-slash"></i> Users Block</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="admin_product.php"><i class="fa-brands fa-buffer"></i> Products</a>
        </li>
        <li class="nav-item">
                <a class="nav-link dropdown-toggle" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-folder"></i> Category
                </a>
                <!-- Submenu for Category -->
                <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="update_jersey_category.php"><i class="fas fa-tshirt"></i> Jersey</a></li>
    <li><a class="dropdown-item" href="update_year_category.php"><i class="far fa-calendar-alt"></i> Year</a></li>
    <li><a class="dropdown-item" href="update_team_category.php"><i class="fas fa-users"></i> Team</a></li>
</ul>

            </li>
        <li class="nav-item">
            <a class="nav-link" href="admin-reports.php"><i class="fa fa-receipt"></i> Reports</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="admin-setting.php"><i class="fa fa-gear"></i> Settings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="log_out.php"><i class="fa-solid fa-power-off"></i> Logout</a>
        </li>
    </ul>
</div>

<!-- Main content -->
<div class="main-content">
    <section class="container mt-2">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="title">Update Jersey Category</h2>
            <a href="add_jersey_category.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Category</a>
        </div>
     
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include database connection
                include "connect.php";

                // SQL query to fetch categories where cat_type is 'jersey'
                $sql = "SELECT * FROM category WHERE cat_type = 'jersey'";
                $result = mysqli_query($con, $sql);

                // Check if query executed successfully
                if ($result && mysqli_num_rows($result) > 0) {
                    // Loop through each row of the result set
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Output category name and action buttons in a table row
                        echo "<tr>";
                        echo "<td>{$row['descript']}</td>";
                        echo "<td>";
                        // Update button
                        echo "<a href='update_jersey_category_code.php?category_id={$row['cat_id']}' class='btn btn-primary btn-sm mx-2'>Update</a>";
                        // Delete button
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    // No categories found
                    echo "<tr><td colspan='2'>No categories found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</div>

<!-- Your JavaScript code -->
<script>
    var categoryBtn = document.querySelector('.sidebar .dropdown-toggle');

    // Get the submenu
    var submenu = document.querySelector('.sidebar .dropdown-menu');

    // Add click event listener to the Category button
    categoryBtn.addEventListener('click', function(e) {
        // Toggle the visibility of the submenu
        submenu.classList.toggle('show');
    });

    // Close the submenu when clicking outside
    window.addEventListener('click', function(e) {
        if (!categoryBtn.contains(e.target)) {
            submenu.classList.remove('show');
        }
    });
</script>
</body>

</html>
