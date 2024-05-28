<?php
include('connect.php');
session_start();
if (!isset($_SESSION['auth_user']['FullName'])) {
    // If not set, redirect to login page
    echo "<script> alert('Please Login First');
    location.href='index.php';</script>";
    exit();
}

// Retrieve transaction data for the logged-in user along with product images
$userId = $_SESSION['auth_user']['ID'];
$query = "SELECT t.*, p.prod_image, p.prod_name, p.prod_price 
          FROM transaction t
          JOIN product_table p ON t.trans_product_id = p.prod_id
          WHERE t.trans_userId = '$userId'
          ORDER BY t.trans_id DESC";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/main.css">
  <style>
    body{
      overflow: hidden;
    }
    /* Custom CSS for profile picture */
    .profile-pic {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background-size: cover;
      background-position: center;
    }
    /* Custom CSS for sidebar */
    .sidebar {
      height: 100vh;
      background-color: #343a40;
      color: #fff;
    }
    /* Custom CSS for sidebar content */
    .sidebar-content {
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: center;
      height: 100%;
      padding-top: 20px; /* Add padding to the top */
    }
    .sidebar-content a {
      width: 100%;
      padding: 10px;
      text-align: left;
      color: #fff;
      text-decoration: none;
      background-color: #343a40;
      margin-bottom: 5px;
      transition: background-color 0.3s ease;
    }
    .sidebar-content a:hover, .sidebar-content a.active {
      background-color: #000000;
      color: #fff;
    }
    .sidebar-content a:nth-last-child(1):hover{
      background-color: #D72323;
    }
    .sidebar-content a i {
      margin-right: 10px;
    }
    /* Main content area */
    .main-content {
      max-height: 90vh;
      overflow-y: auto;
      padding: 20px;
      scrollbar-width: none; 
    /* Hide scrollbar for other browsers */
    -ms-overflow-style: none; 
    height: 90vh;
    }
    /* Custom styles for cards */
    .card {
  margin-bottom: 20px;
  border: 2px solid #000; /* Adjust the thickness and color of the border */
  border-radius: 15px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
    .card img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
      margin: auto;
    }
    .card-body {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .card-title {
      font-size: 1.25rem;
      font-weight: bold;
    }
    .card-text {
      font-size: 1rem;
      color: #555;
    }
    .card-footer {
      background-color: #f8f9fa;
      border-top: 1px solid #e9ecef;
      text-align: right;
    }
    nav{
      background-color: #000000;
    }
 
  </style>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark border-bottom border-dark">
  <div class="container-fluid">
    <!-- Toggler/collapsible Button -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Links -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="navbar-brand" href="index.php">
            <i class="fas fa-home  text-light"></i>
          </a>
        </li>
        <!-- Add more navbar links as needed -->
        <li class="nav-item">
          <a class="navbar-brand" href="product.php">
            <i class="fas fa-store  text-light"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 col-xl-2 sidebar bg-dark">
      <div class="sidebar-content ">
        <div class="profile-pic mb-3" id="profile-pic">
          <?php
          if (isset($_SESSION['auth_user']['ProfilePic'])) {
            $user_image = $_SESSION['auth_user']['ProfilePic'];
            echo "<img src='{$user_image}' alt='Profile Picture' class='profile-pic'>";
          }
          ?>
        </div>
        <a href="user.php" class="btn btn-secondary text-start  <?php if (basename($_SERVER['PHP_SELF']) == 'user.php') echo 'active'; ?>"><i class="fas fa-check-circle"></i> Ordered</a>
        <a href="user_cart.php" class="btn btn-secondary text-start <?php if (basename($_SERVER['PHP_SELF']) == 'user_cart.php') echo 'active'; ?>"><i class="fas fa-shopping-cart"></i> Cart</a>
        <a href="user_settings.php" class="btn btn-secondary text-start <?php if (basename($_SERVER['PHP_SELF']) == 'user_settings.php') echo 'active'; ?>"><i class="fas fa-cog"></i> User Settings</a>
        <a href="log_out.php" class="btn btn-danger text-start"><i class="fas fa-sign-out-alt"></i> Log Out</a>
      </div>
    </div>
    <!-- Content -->
    <div class="col-md-10 main-content">
      <h2>Your Transactions</h2>
      <?php
      if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<div class='card'>";
              echo "<div class='row g-0'>";
              echo "<div class='col-md-2 d-flex align-items-center'>";
              echo "<img src='" . $row['prod_image'] . "' class='img-fluid rounded-start' alt='Product Image'>";
              echo "</div>";
              echo "<div class='col-md-8'>";
              echo "<div class='card-body'>";
              echo "<h5 class='card-title'>Transaction ID: " . $row['trans_id'] . "</h5>";
              echo "<p class='card-text'>Transaction Date: " . $row['trans_date'] . "</p>";
              echo "<p class='card-text'>Product Name: " . $row['prod_name'] . "</p>";
              echo "<p class='card-text'>Product Price: $" . $row['prod_price'] . "</p>";
              echo "<p class='card-text'>Order Quantity: " . $row['trans_prodcut_qty'] . "</p>";
              echo "<p class='card-text'>Amount: $" . $row['trans_total'] . "</p>";
              echo "</div>";
              echo "</div>";
              echo "</div>";
              echo "</div>";
          }
      } else {
          echo "<p>No transactions found</p>";
      }
      ?>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0-alpha1/js/bootstrap.min.js"></script>
</body>
</html>
