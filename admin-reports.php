<?php
include "connect.php";
session_start();
if (!isset($_SESSION['auth_admin']['adminFullName'])) {
    // If not logged in, redirect to the login page
    echo "<script> alert('Please Login First');
        location.href='login.php';</script>";
    exit();
}

// Initialize start and end date variables
$startDate = ''; // Initialize with empty string
$endDate = ''; // Initialize with empty string

// Check if start_date and end_date are set in the GET request
if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    // Assign start and end dates from GET request
    $startDate = $_GET['start_date'];
    $endDate = $_GET['end_date'];

    // Construct the SQL query with date filtering
    $sql = "SELECT * FROM transaction WHERE trans_date BETWEEN '$startDate' AND '$endDate'";
} else {
    // Construct the SQL query without date filtering
    $sql = "SELECT * FROM transaction";
}

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
            <!-- Date filter -->
            <div class="row mb-3">
                <div class="col">
                    <form action="" method="GET">
                        <div class="row">
                            <div class="col">
                                <label for="start_date" class="form-label">Start Date:</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $startDate; ?>">
                            </div>
                            <div class="col">
                                <label for="end_date" class="form-label">End Date:</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $endDate; ?>">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary mt-4">Filter</button>
                                <?php
                                // Check if the SQL query is set
                                if (isset($sql)) {
                                    // Echo a print button if the SQL query is set
                                    echo '<a href="generate_pdf.php?start_date=' . $startDate . '&end_date=' . $endDate . '" class="btn btn-success mt-4 ms-2">Print PDF</a>';
                                }
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Your existing content goes here -->
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">User ID</th>
                        <th scope="col">Product ID</th>
                        <th scope="col">Date</th>
                     
                    </tr>
                </thead>
                <tbody>

                    <?php
                    // Query to retrieve data from the transaction table
                    $result = mysqli_query($con, $sql);

                    // Fetch data and display it in the table
                    while ($row = mysqli_fetch_assoc($result)) {
                        $trans_id = $row['trans_id'];
                        $trans_User_id = $row['trans_userid'];
                        $trans_Prod_id = $row['trans_product_id'];
                        $trans_Date = $row['trans_date'];

                        echo "
                <tr>
                <th scope='row'>$trans_id</th>
                <td>$trans_User_id</td>
                <td>$trans_Prod_id</td>
                <td>$trans_Date</td>
                </tr>";
                    }
                    ?>
                </tbody>
         </table>
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