<?php
include "connect.php";
session_start();
if (!isset($_SESSION['auth_admin']['adminID'])) {
    // Kung wala, ireredirect sa login page
    echo "<script> alert('Please Login First');
        location.href='login.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style2.css">
    <link rel="stylesheet" href="css/dropdown.css">
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
    <div class="main-content">
        <section class="container mt-5">
            <div class="container">
                <div class="row">

                </div>
                <div class="row justify-content-start">
                    <div class="col-md-6">
                        <div class="d-flex  mb-3">
                            <h2>Block User</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-sm text-center ">
                                <thead class="table-dark">
                                    <tr>
                                        <th>User ID</th>
                                        <th>Blocked</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php
                                $sql = "Select * from user_block";
                                $result = mysqli_query($con, $sql);
                                if ($result) {
                                    // echo $row['name'];
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $id = $row['user_id'];
                                        $first = $row['is_blocked'];
                                        if ($first == 1) {
                                            $first = 'true';
                                        } else {
                                            $first = 'false';
                                        }
                                        // $nine = $row[''];
                                        echo '<tr>
                                    <td style="padding-top: 13px">' . $id . '</td>
                                    <td style="padding-top: 13px">' . $first . '</td>
                                    <td style="padding-top: 13px">
                                         <button id="btned2"><a href="admin_user_block_update.php?updateid=' . $id . '"><i class="fa-solid fa-user-check"></i> Unblock</a></button>
                                    </td>
                                </tr>';
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        // Get the current page URL
        var currentPageUrl = window.location.href;

        // Select all links in the sidebar
        var sidebarLinks = document.querySelectorAll('.sidebar .nav-link');

        // Loop through each link and check if its href matches the current page URL
        sidebarLinks.forEach(function(link) {
            if (link.getAttribute('href') === currentPageUrl) {
                // Add the 'active' class to the link
                link.classList.add('active');
            }
        });
    </script>
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