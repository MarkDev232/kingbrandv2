<?php
include('connect.php');
session_start();
if (!isset($_SESSION['auth_user']['FullName'])) {
  // If user is not logged in, redirect to login page
  echo "<script> alert('Please Login First');
    location.href='index.php';</script>";
  exit();
}

// Retrieve user ID from session
$userID = $_SESSION['auth_user']['ID'];

// Fetch cart items for the current user
$sql = "SELECT uc.card_id, uc.cart_productId, uc.cart_prod_qty, pt.* FROM user_cart uc
        INNER JOIN product_table pt ON uc.cart_productId = pt.prod_id
        WHERE uc.cart_userId = $userID";
$result = mysqli_query($con, $sql);
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
  <style>
  body {
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
      overflow-y: auto;
    }

    /* Custom CSS for sidebar content */
    .sidebar-content {
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: center;
      height: 100%;
      padding-top: 20px;
      /* Add padding to the top */
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

    .sidebar-content a:hover,
    .sidebar-content a.active {
      background-color: #000000;
      color: #fff;
    }

    .sidebar-content a:nth-last-child(1):hover {
      background-color: #D72323;
    }

    .sidebar-content a i {
      margin-right: 10px;
    }

    /* Main content area */
    .main-content {
      max-height: calc(100vh - 56px);
      padding: 20px;
    }
    /* Custom styles for cards */
    .card {
      margin-bottom: 20px;
      border: none;
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
  #container-main{
    height:90vh;
    margin-left: 95px;
    -ms-overflow-style: none; 
    scrollbar-width: none; 
  }
  .row input[type="checkbox"] {
  border-color: #a3a0a0; /* Change border color to black */
}
    
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark border-bottom border-dark">
    <div class="container-fluid">
      <!-- Logo and home button -->
      <!-- <a class="navbar-brand" href="index.php">
      <i class="fas fa-home"></i>
    </a> -->

      <!-- Toggler/collapsible Button -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
              <i class="fas fa-store text-light"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-2 col-xl-2 navbar-dark bg-dark text-white sidebar">
        <div class="sidebar-content">
          <div class="profile-pic mb-3" id="profile-pic">
            <?php
            if (isset($_SESSION['auth_user']['ProfilePic'])) {
              $user_image = $_SESSION['auth_user']['ProfilePic'];
              echo "<img src='{$user_image}' alt='Profile Picture' class='profile-pic'>";
            }
            ?>
          </div>
          <a href="user.php" class="btn btn-secondary text-start <?php if (basename($_SERVER['PHP_SELF']) == 'user.php') echo 'active'; ?>"><i class="fas fa-check-circle"></i> Ordered</a>
          <a href="user_cart.php" class="btn btn-secondary text-start <?php if (basename($_SERVER['PHP_SELF']) == 'user_cart.php') echo 'active'; ?>"><i class="fas fa-shopping-cart"></i> Cart</a>
          <a href="user_settings.php" class="btn btn-secondary text-start <?php if (basename($_SERVER['PHP_SELF']) == 'user_settings.php') echo 'active'; ?>"><i class="fas fa-cog"></i> User Settings</a>
          <a href="log_out.php" class="btn btn-danger text-start"><i class="fas fa-sign-out-alt"></i> Log Out</a>
        </div>
      </div>
      <!-- Content -->
      <div class="col-md-9  overflow-y-scroll" id="container-main">
        <div class="p-4">

          <!-- Display cart items -->
          <div class="row">
            <?php
            // Initialize total value variable
            $totalValue = 0;

            // Loop through each cart item
            while ($row = mysqli_fetch_assoc($result)) {
              // Retrieve product details from the cart table
              $productID = $row['cart_productId'];
              $cartQuantity = $row['cart_prod_qty'];
              $cartID = $row['card_id'];

              // Fetch product details from product_table using productID
              $productQuery = "SELECT * FROM product_table WHERE prod_id = $productID";
              $productResult = mysqli_query($con, $productQuery);
              $productRow = mysqli_fetch_assoc($productResult);
              $productName = $productRow['prod_name'];
              $productTeam = $productRow['prod_team'];
              $productJersey = $productRow['prod_jersey'];
              $productImage = $productRow['prod_image'];
              // Calculate product value and add to total
              $productValue = $productRow['prod_price'] * $cartQuantity;
              // $totalValue += $productValue; // Accumulate the product value
              $totalValue = 0

              // Display product details in Bootstrap card format
            ?>
              <div class="row border border-black mt-3  border border-black rounded-4 mt-3 shadow p-2  rounded" id="product_<?php echo $productID; ?>">
                <div class="col-lg-1 col-md-12 mb-4 mb-lg-0">
                  <!-- Checkbox -->
                  <input type="checkbox" class="form-check-input custom-checkbox " id="checkbox_<?php echo $cartID; ?>" onchange="updateTotalValueAsync()">
                </div>

                <div class="col-lg-2 col-md-12 mb-4 mb-lg-0">
                  <!-- Image -->
                  <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                    <img src="<?php echo $productImage; ?>" class="w-100" alt="Product Image" />
                    <a href="#!">
                      <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                    </a>
                  </div>
                  <!-- Image -->
                </div>

                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0 py-4">
                  <!-- Data -->
                  <p><strong><?php echo $productName; ?></strong></p>
                  <p>Team: <?php echo $productTeam; ?></p>
                  <p>Jersey Type: <?php echo $productJersey; ?></p>
                  <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-danger btn-sm me-1 mb-2" data-mdb-tooltip-init title="Remove item" onclick="deleteCartItem(<?php echo $cartID; ?>)">
                    <i class="fas fa-trash" id="trash<?php echo $cartID; ?>"></i>
                  </button>
                  <!-- Data -->
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 py-2">
                  <!-- Quantity -->
                  <div class="d-flex justify-content-between align-items-center">
                    <button class="btn btn-primary" onclick="updateQuantity(<?php echo $productID; ?>, <?php echo $cartID; ?>, 'decrement')" <?php echo $cartQuantity === 1 ? 'disabled' : ''; ?>>-</button>
                    <p class="card-text">Quantity: <?php echo $cartQuantity; ?></p>
                    <button class="btn btn-primary" onclick="updateQuantity(<?php echo $productID; ?>, <?php echo $cartID; ?>, 'increment')">+</button>
                  </div>
                  <!-- Quantity -->

                  <!-- Price -->
                  <p class="text-start text-md-center" id='prod_value_<?php echo $cartID; ?>'>
                    <strong>$<?php echo $productValue; ?>.00</strong>
                  </p>
                  <!-- Price -->
                </div>
              </div>
              <!-- card end -->
            <?php
            }
            ?>
          </div>

          <!-- Total product value and Buy button -->
          <div class="row mt-4">
            <div class="col-md-6">
              <h4 class="total-value">Total Value: $<?php echo number_format($totalValue, 2); ?></h4>
            </div>
            <div class="col-md-6 text-end">
              <button class="btn btn-primary" onclick="buyNow()">Buy Now</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0-alpha1/js/bootstrap.min.js"></script>
  <script>
    // Function to update product quantity
    // Function to update product quantity
    // Function to update product quantity
    function updateQuantity(productId, cardId, action) {
      var quantityElement = document.querySelector(`#product_${productId} .card-text`);
      var currentQuantity = parseInt(quantityElement.innerText.split(': ')[1]);

      if (action === 'decrement' && currentQuantity === 1) {
        return;
      }

      var newQuantity = action === 'decrement' ? currentQuantity - 1 : currentQuantity + 1;
      quantityElement.innerText = `Quantity: ${newQuantity}`;

      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            var productValueElement = document.getElementById(`prod_value_${cardId}`);
            productValueElement.innerHTML = '<strong>$' + response.productValue.toFixed(2) + '</strong>';
            updateTotalValueAsync();
            // Reload the page after updating the quantity
            window.location.reload();
          } else {
            console.error('Error updating quantity:', xhr.statusText);
          }
        }
      };
      xhr.open('POST', 'update_quantity.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.send(`productId=${productId}&cardId=${cardId}&action=${action}&quantity=${newQuantity}`);
    }



    function updateTotalValueAsync() {
      var totalValue = 0;
      var productCheckboxes = document.querySelectorAll('[id^="checkbox_"]');

      // Loop through each product checkbox
      productCheckboxes.forEach(function(checkbox) {
        var productId = checkbox.id.split('_')[1];

        // Find the corresponding product value based on the checkbox ID
        var productValueElement = document.getElementById(`prod_value_${productId}`);

        // If checkbox is checked and the product value element exists, add product value to total value
        if (checkbox.checked && productValueElement) {
          var productValue = parseFloat(productValueElement.innerText.split('$')[1]);
          totalValue += productValue;
        }
      });

      // Update total value on the page
      var totalValueElement = document.querySelector('.total-value');
      totalValueElement.innerText = 'Total Value: $' + totalValue.toFixed(2);
      console.log('Total Value: $' + totalValue.toFixed(2));
    }




    function buyNow() {
      var productCheckboxes = document.querySelectorAll('[id^="checkbox_"]');
      var selectedProducts = [];

      productCheckboxes.forEach(function(checkbox) {
        var productId = checkbox.id.split('_')[1];
        if (checkbox.checked) {
          selectedProducts.push(productId);
        }
      });

      if (selectedProducts.length > 0) {
        // Redirect to another file for buying transaction with selected products data
        window.location.href = 'buy_transaction.php?cartid=' + selectedProducts.join(',');
      } else {
        alert('Please select at least one product to buy.');
      }
    }

    function deleteCartItem(cartID) {
      if (confirm('Are you sure you want to remove this item?')) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              var response = JSON.parse(xhr.responseText);
              if (response.status === 'success') {
                // Reload the page after deleting the item
                window.location.reload();
              } else {
                console.error('Error deleting item:', response.message);
              }
            } else {
              console.error('Error deleting item:', xhr.statusText);
            }
          }
        };
        xhr.open('POST', 'delete_cart_item.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('cartID=' + cartID);
      }
    }
  </script>

</body>

</html>