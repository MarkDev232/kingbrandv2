<?php
include('connect.php');
session_start();
?>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>King Brand</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/main.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/product-style.css" />
    <!-- Include Bootstrap JS and jQuery -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
    
    <!-- Include JavaScript function -->

</head>

<body>
    <!-- Navigation and other HTML elements -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container d-flex">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="./images/mainlogo.png" alt="NBA Jersey Shop Logo" style="height: 60px;" /> <!-- Adjust height as needed -->
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
                        <a class="nav-link" href="index.php" id="btn-home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="product.php">Shop</a>
                    </li>
                    <div class="mb-3">
                        <label for="" class="form-label">Password</label>
                        <input
                            type="password"
                            class="form-control"
                            name=""
                            id=""
                            placeholder=""
                        />
                    </div>
                    
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

    <!-- Content -->
    <div class="container pt-3 pb-5">
        <div class="row">
            <div class="col-lg-3">
                <h1 class="h2 pb-1">Categories</h1>
                <ul class="list-unstyled templatemo-accordion overflow-y-scroll" style='height:70vh;'>
                    <div class="form-check">
                        <li class="pb-3">
                            <a class="collapsed d-flex justify-content-evenly h5 text-decoration-none" href="#" data-toggle="collapse" data-target="#team-checkboxes">
                                Team <i class="fas fa-chevron-down"></i>
                            </a>
                            <ul id="team-checkboxes" class="collapse list-unstyled pl-3">
                                <!-- Team checkboxes -->
                                <?php
                                $sql = "SELECT DISTINCT prod_team FROM product_table ORDER BY prod_team ASC";
                                $result = mysqli_query($con, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $team = $row['prod_team'];
                                        echo '
                                    <li>
                                        <input class="form-check-input filter-checkbox" type="checkbox" name="team" value="' . htmlspecialchars($team) . '" id="team-' . htmlspecialchars($team) . '"/>
                                        <label class="form-check-label" for="team-' . htmlspecialchars($team) . '">' . htmlspecialchars($team) . '</label>
                                    </li>
                                    ';
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                    </div>

                    <div class="form-check">
                        <li class="pb-3">
                            <a class="collapsed d-flex justify-content-evenly h5 text-decoration-none" href="#" data-toggle="collapse" data-target="#jersey-checkboxes" aria-expanded="false">
                                Jersey <i class="fas fa-chevron-down"></i>
                            </a>
                            <ul id="jersey-checkboxes" class="collapse list-unstyled pl-3">
                                <!-- Jersey checkboxes -->
                                <?php

                                $sql = "SELECT DISTINCT prod_jersey FROM product_table ORDER BY prod_jersey ASC";
                                $result = mysqli_query($con, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $jersey = $row['prod_jersey'];
                                        echo '
                                   <li>
                                       <input class="form-check-input filter-checkbox" type="checkbox" name="jersey" value="' . htmlspecialchars($jersey) . '" id="jersey-' . htmlspecialchars($jersey) . '"/>
                                       <label class="form-check-label" for="jersey-' . htmlspecialchars($jersey) . '">' . htmlspecialchars($jersey) . '</label>
                                   </li>
                                   ';
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                    </div>
                    <div class="form-check">
                        <li class="pb-3">
                            <a class="collapsed d-flex justify-content-evenly h5 text-decoration-none" href="#" data-toggle="collapse" data-target="#year-checkboxes">
                                Year <i class="fas fa-chevron-down"></i></a>
                            <ul id="year-checkboxes" class="collapse list-unstyled pl-3">
                                <li>
                                    <?php
                                    $sql = "SELECT DISTINCT prod_year FROM product_table ORDER BY prod_year DESC";
                                    $result = mysqli_query($con, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $year = $row['prod_year'];
                                            echo '
                                       <li>
                                           <input class="form-check-input filter-checkbox" type="checkbox" name="year" value="' . htmlspecialchars($year) . '" id="year-' . htmlspecialchars($year) . '"/>
                                           <label class="form-check-label" for="year-' . htmlspecialchars($year) . '">' . htmlspecialchars($year) . '</label>
                                       </li>
                                       ';
                                        }
                                    }
                                    ?>
                                </li>
                            </ul>
                        </li>
                                </div >
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-md-6">
                        <form class="form-inline my-2 my-lg-0 d-flex">
                            <input id="search-input" class="form-control mr-sm-2 mx-2" type="search" placeholder="Search" aria-label="Search" />
                        </form>
                    </div>
                    <div class="col-md-6 pb-3">
                        <div class="d-flex">
                            <select id="sort-select" class="form-control">
                                <option>&#9660; Sort Name</option>
                                <option value="A to Z">A to Z</option>
                                <option value="Z to A">Z to A</option>
                            </select>

                            <select id="sort-select-price" class="form-control" onchange="sortProductsByPrice()">
                                <option>&#9660; Sort Price</option>
                                <option>High to Low</option>
                                <option>Low to High</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row overflow-y-scroll" style='height:80vh;' id='product-container'>
                    <!-- Product listing will be inserted here dynamically -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->

    <script>
        $(document).ready(function() {
            // Initial fetch of products
            fetchProducts();

            // Function to fetch products
            function fetchProducts(filters = {}) {
                $.ajax({
                    url: 'fetch_products.php',
                    type: 'GET',
                    dataType: 'json',
                    data: filters,
                    success: function(data) {
                        displayProducts(data);
                    },
                    error: function(error) {
                        console.log("Error fetching products:", error);
                    }
                });
            }

            // Function to display products
            function displayProducts(products) {
                const container = $('#product-container');
                container.empty();

                products.forEach(product => {
                    const disabled = product.prod_qty <= 0 ? 'disabled' : '';
                    const productHtml = `
                   <div class="col-md-4 product" data-team="${product.prod_team}" data-name="${product.prod_name}" data-jersey="${product.prod_jersey}" data-year="${product.prod_year}" data-index="${product.prod_id}">
                       <div class="card mb-4 product-wap rounded-0">
                           <div class="card rounded-0">
                               <img class="card-img rounded-0" src="${product.prod_image}" style="height: 280px;">
                           </div>
                           <div class="card-body text-start">
                               <a href="#" class="h3 text-decoration-none fs-5 product-name">${product.prod_name}</a>
                               <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                   <li>
                                       <span class="badge bg-primary">${product.prod_jersey}</span>
                                       <span class="badge bg-danger mx-1">${product.prod_team}</span>
                                       <span class="badge bg-success">${product.prod_year}</span>
                                   </li>
                               </ul>
                               <p class="text-start mb-0 fs-4 fw-bold">$${product.prod_price}</p>
                               <p class="text-start mb-0 fs-6"><strong>Sold:</strong> ${product.prod_sold}</p>
                               <a href="single_product.php?id=${product.prod_id}&name=${product.prod_name}&team=${product.prod_team}&jersey=${product.prod_jersey}&year=${product.prod_year}&price=${product.prod_price}&image=${product.prod_image}" class="btn btn-success my-2 fs-6 buy-btn" style="width: 100%;" ${disabled}>Buy</a>
                               <a href="add_to_cart.php?id=${product.prod_id}" class="btn btn-warning fs-6" style="width: 100%;" ${disabled}>
                                   <i class="fas fa-shopping-cart"></i> Add to Cart
                               </a>
                           </div>
                       </div>
                   </div>`;
                    container.append(productHtml);
                });

                // Add event listener to prevent clicking on disabled buy buttons
                $('.buy-btn').click(function(e) {
                    if ($(this).attr('disabled')) {
                        e.preventDefault();
                        alert('This product is currently out of stock.');
                    }
                });
            }

            // Function to sort products by name
            function sortProductsByName(order) {
                const sortedProducts = $('#product-container .product').toArray().sort((a, b) => {
                    const nameA = $(a).data('name').toUpperCase();
                    const nameB = $(b).data('name').toUpperCase();
                    if (order === 'A to Z') {
                        return nameA.localeCompare(nameB);
                    } else {
                        return nameB.localeCompare(nameA);
                    }
                });
                $('#product-container').empty().append(sortedProducts);
            }

            // Function to sort products by price
            function sortProductsByPrice(order) {
                const sortedProducts = $('#product-container .product').toArray().
                sort((a, b) => {
                    const priceA = parseFloat($(a).find('.fw-bold').text().substring(1));
                    const priceB = parseFloat($(b).find('.fw-bold').text().substring(1));
                    if (order === 'Low to High') {
                        return priceA - priceB;
                    } else {
                        return priceB - priceA;
                    }
                });
                $('#product-container').empty().append(sortedProducts);
            } // Event listener for sorting by name
            $('#sort-select').change(function() {
                const order = $(this).val();
                sortProductsByName(order);
            });

            // Event listener for sorting by price
            $('#sort-select-price').change(function() {
                const order = $(this).val();
                sortProductsByPrice(order);
            });

            // Event listener for changes in the checkboxes
            $('.filter-checkbox').on('change', function() {
                const filters = {};

                // Collect selected team filters
                const selectedTeams = [];
                $('input[name="team"]:checked').each(function() {
                    selectedTeams.push($(this).val());
                });
                if (selectedTeams.length > 0) {
                    filters.teams = selectedTeams;
                }

                // Collect selected jersey filters
                const selectedJerseys = [];
                $('input[name="jersey"]:checked').each(function() {
                    selectedJerseys.push($(this).val());
                });
                if (selectedJerseys.length > 0) {
                    filters.jerseys = selectedJerseys;
                }

                // Collect selected year filters
                const selectedYears = [];
                $('input[name="year"]:checked').each(function() {
                    selectedYears.push($(this).val());
                });
                if (selectedYears.length > 0) {
                    filters.years = selectedYears;
                }

                // Fetch and display products based on selected filters
                fetchProducts(filters);
            });

            // Event listener for live search
            $('#search-input').on('input', function() {
                const searchTerm = $(this).val().trim().toLowerCase();
                const products = $('#product-container .product');
                products.each(function() {
                    const productName = $(this).data('name').toLowerCase();
                    if (productName.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });

        function updateCartCount() {
            $.ajax({
                url: 'get_cart_count.php', type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#cart-count').text(data.count);
                },
                error: function(error) {
                    console.log("Error fetching cart count:", error);
                }
            });
        }

        // Call the function initially to display the cart count
        updateCartCount();
    </script>
</body>

</html>