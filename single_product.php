<?php
include('connect.php');
session_start();

// Check if the session is for an admin
if (isset($_SESSION['auth_admin']['adminID'])) {
    // Redirect to product.php if an admin session is detected
    echo "<script>
        alert('Admin can\'t buy products');
        window.location.href = 'product.php';
    </script>";
    exit();
}

// Retrieve product details from GET parameters
$id = $_GET['id'];
$name = $_GET['name'];
$team = $_GET['team'];
$jersey = $_GET['jersey'];
$year = $_GET['year'];
$price = $_GET['price'];
$image = $_GET['image'];

// Check if user session is set
if (isset($_SESSION['auth_user']['ID'])) {
    $userID = $_SESSION['auth_user']['ID'];
}

// Initialize the quantity variable with a default value
$quantity = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>King Brand</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">

    <!-- Slick -->
    <link rel="stylesheet" type="text/css" href="assets/css/slick.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css">
    <link rel="stylesheet" href="css/main.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
   <!-- Navigation and other HTML elements -->
   <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container d-flex  ">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="./images/mainlogo.png" alt="NBA Jersey Shop Logo" style="height: 60px;" /> <!--
              Adjust height as needed -->
                <span>King Brand</span>
            </a>

            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index2.html" id="btn-home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="product.xml">Shop</a>
                    </li>

                    <?php
    if (isset($_SESSION['auth_user']['ID'])) {
        $user_image = $_SESSION['auth_user']['ProfilePic'];
        echo '<li class="nav-item">
        <a href="user_cart.php" class="nav-link">
            <i class="fas fa-shopping-cart"></i> Cart <span id="cart-count" class="badge bg-danger"></span>
        </a>
    </li>';
    echo '<li class="nav-item">
        <a href="user.php" class="nav-link">
            <i class="fas fa-user"></i> User 
        </a>
    </li>';


    } 
    
    ?>

                    

                </ul>
            </div>
            

        </div>
    </nav>
    <!-- Close Header -->

    <!-- Modal -->
    <div class="modal fade" id="codModal" tabindex="-1" aria-labelledby="codModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="codModalLabel">Cash on Delivery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Confirm your order and proceed with the cash on delivery payment method.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <!-- Add form submission button for COD -->
                    <button type="submit" class="btn btn-primary" id="confirmCOD">Confirm COD</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Open Content -->
    <section class="bg-light">
        <div class="container pb-5">
            <div class="row">
                <!-- Product image column -->
                <div class="col-lg-5 mt-5">
                    <!-- Product image card -->
                    <div class="card mb-3">
                        <img class="card-img img-fluid" id="product-detail" alt="Product Image" src="<?php echo $image; ?>">
                    </div>
                </div>
                <!-- Product details column -->
                <div class="col-lg-7 mt-5">
                    <!-- Product details card -->
                    <div class="card">
                        <div class="card-body">
                            <!-- Product name -->
                            <h1 class="h2" id="product-name"><?php echo $name; ?></h1>

                            <!-- Product price -->
                            <p class="h3 py-2" id="product-price">&#36;<?php echo $price; ?></p>

                            <!-- Product attributes -->
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6>Team:</h6>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-muted badge text-bg-warning" id="product-team"><strong><?php echo $team; ?></strong></p>
                                </li>
                            </ul>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6>Jersey Type:</h6>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-muted badge text-bg-warning" id="product-jersey"><strong><?php echo $jersey; ?></strong></p>
                                </li>
                            </ul>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6>Year:</h6>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-muted badge text-bg-warning text-light " id="product-year"><strong><?php echo $year; ?></strong></p>
                                </li>
                            </ul>

                            <!-- Hidden input fields -->
                            <input type="hidden" id="product-price" value="<?php echo $price; ?>">
                            <input type="hidden" name="product-title" value="Activewear">

                            <!-- Quantity input -->
                            <div class="row">
                                <div class="col-auto">
                                    <ul class="list-inline pb-3">
                                        <li class="list-inline-item text-right">
                                            Quantity
                                            <!-- Update the input value with PHP -->
                                            <input type="hidden" name="product-quantity" id="product-quantity" value="<?php echo $quantity; ?>">
                                        </li>
                                        <li class="list-inline-item"><span class="btn btn-success" id="btn-minus">-</span></li>
                                        <!-- Update the quantity display dynamically -->
                                        <li class="list-inline-item"><span class="badge bg-secondary" id="var-value"><?php echo $quantity; ?></span></li>
                                        <li class="list-inline-item"><span class="btn btn-success" id="btn-plus">+</span></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Total price -->
                            <div class="row pb-3">
                                <div class="col d-grid">
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <h6>Total:</h6>
                                        </li>
                                        <li class="list-inline-item">
                                            <p class="text-muted" id="product-total"><strong><?php echo $price; ?></strong></p>
                                        </li>
                                    </ul>
                                    <!-- Buy button -->
                                    <button type="button" class="btn btn-success btn-lg" id="buyButton">Buy</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Close Content -->

    <!-- Start Script -->
    <script src="assets/js/slick.min.js"></script>
    <script>
        $(document).ready(function() {

            // Function to increment the quantity
            $('#btn-plus').click(function() {
                var quantity = parseInt($('#product-quantity').val()) + 1;
                $('#product-quantity').val(quantity);
                $('#var-value').text(quantity); // Update the displayed quantity
                updateTotal(quantity);
            });

            // Function to decrement the quantity
            $('#btn-minus').click(function() {
                var quantity = parseInt($('#product-quantity').val()) - 1;
                if (quantity < 1) quantity = 1; // Ensure quantity is not less than 1
                $('#product-quantity').val(quantity);
                $('#var-value').text(quantity); // Update the displayed quantity
                updateTotal(quantity);
            });

            // Function to update the total based on quantity
            function updateTotal(quantity) {
                var price = parseFloat($('#product-price').text().replace('$', '')); // Get the current product price
                var total = price * quantity;
                $('#product-total').text('$' + total.toFixed(2));
            }

            $('#buyButton').click(function() {
                // Get user ID from session if available
                var userID = "<?php echo isset($userID) ? $userID : ''; ?>";
                // Get other product details
                var productID = "<?php echo $id; ?>";
                var quantity = $('#product-quantity').val();
                var total = $('#product-total').text().replace('$', '');

                // Construct the anchor tag with query parameters
                var anchor = $('<a>', {
                    href: 'buying_product.php?userID=' + userID + '&productID=' + productID + '&quantity=' + quantity + '&total=' + total,
                    style: 'display: none;', // Hide the anchor tag
                    id: 'buyAnchor'
                });

                // Append the anchor tag to the body and trigger a click to initiate the redirection
                $('body').append(anchor);
                $('#buyAnchor')[0].click();

                // Remove the anchor tag after click
                $('#buyAnchor').remove();
            });
        });

        // Function to handle back button click
        function goBack() {
            window.history.back();
        }
    </script>
    <!-- End Script -->
</body>

</html>
