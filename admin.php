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
    <title>Document</title>
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

        .sidebar .nav-link {
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

        .dropdown-menu {
            background-color: #343a40;
        }

        .dropdown-item {
            color: rgba(255, 255, 255, 0.5);
        }

        .dropdown-item:hover {
            color: white;
            background-color: #343a40;

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
        <section class="container mt-5">
            <div class="row">
                <div class="container-fluid pt-4 px-4">
                    <div class="row g-2">
                        <div class="col-sm-6 col-xl-6">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 border border-primary">
                                <i class="fa fa-chart-line fa-3x text-primary"></i>
                                <div class="ms-3">
                                    <p class="mb-2">Today Sale this month</p>
                                    <?php
                                    // Compute total sales for this month
                                    $query_total_sales = "SELECT SUM(trans_total) AS total_sales 
                                                      FROM transaction 
                                                      WHERE MONTH(trans_date) = '$month' AND YEAR(trans_date) = '$year'";
                                    $result_total_sales = mysqli_query($con, $query_total_sales);
                                    $row_total_sales = mysqli_fetch_assoc($result_total_sales);
                                    $total_sales = $row_total_sales['total_sales'];
                                    ?>
                                    <h6 class="mb-0">$<?php echo $total_sales; ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-6">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 border border-primary">
                                <i class="fa fa-chart-bar fa-3x text-primary"></i>
                                <div class="ms-3">
                                    <p class="mb-2">Total User Register</p>
                                    <?php
                                    // Get the total number of users
                                    $query_total_users = "SELECT COUNT(id) AS total_users FROM `user_table`";
                                    $result_total_users = mysqli_query($con, $query_total_users);
                                    $row_total_users = mysqli_fetch_assoc($result_total_users);
                                    $total_users = $row_total_users['total_users'];
                                    ?>
                                    <h6 class="mb-0"><?php echo $total_users; ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-6">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 border border-primary">
                                <i class="fa fa-chart-area fa-3x text-primary"></i>
                                <div class="ms-3">
                                    <p class="mb-2">Today Quantity Products sold</p>
                                    <?php
                                    // Compute total quantity of products sold today
                                    $query_total_quantity = "SELECT SUM(trans_prodcut_qty) AS total_quantity 
                                                         FROM transaction 
                                                         WHERE DAY(trans_date) = '$day' AND MONTH(trans_date) = '$month' AND YEAR(trans_date) = '$year'";
                                    $result_total_quantity = mysqli_query($con, $query_total_quantity);
                                    $row_total_quantity = mysqli_fetch_assoc($result_total_quantity);
                                    $total_quantity = $row_total_quantity['total_quantity'];
                                    if (is_null($total_quantity)) {
                                        $total_quantity = 0;
                                    }
                                    ?>
                                    <h6 class="mb-0"><?php echo $total_quantity; ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-6">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 border border-primary">
                                <i class="fa fa-chart-pie fa-3x text-primary"></i>
                                <div class="ms-3">
                                    <p class="mb-2">Total Order This Day</p>
                                    <?php
                                    // Compute total orders for today
                                    $query_total_orders = "SELECT SUM(trans_total) AS total_orders 
                                                       FROM transaction 
                                                       WHERE DAY(trans_date) = '$day' AND MONTH(trans_date) = '$month' AND YEAR(trans_date) = '$year'";
                                    $result_total_orders = mysqli_query($con, $query_total_orders);
                                    $row_total_orders = mysqli_fetch_assoc($result_total_orders);
                                    $total_orders = $row_total_orders['total_orders'];
                                    if (is_null($total_orders)) {
                                        $total_orders = 0;
                                    }
                                    ?>
                                    <h6 class="mb-0">$<?php echo $total_orders; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</body>
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

</html>