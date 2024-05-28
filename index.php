<?php
include('connect.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>King Brand</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
    <style>
        /* CSS for fixed image height */
        .card-img-top.product-img {
            height: 350px;
            /* Adjust the height as needed */
           
            /* Ensures the image covers the entire space */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container d-flex ">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="./images/mainlogo.png" alt="NBA Jersey Shop Logo" style="height: 60px;">
                <!-- Adjust height as needed -->
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
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="product.php">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#highlights">Highlights</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="my_storyboard.php">My StoryBoard</a>
                    </li>

                </ul>
            </div>

            <!-- Signing Button -->
            <div class='mx-2' id="log_in_btn">

            </div>
            <div id="Sign_in_btn">

                <!-- <a href="Sign_Up.php" class="btn btn-warning">Sign Up</a> -->

            </div>
            <?php
            if (isset($_SESSION['auth_user']['ID'])) {
                $user_image = $_SESSION['auth_user']['ProfilePic'];
                echo '<script>document.getElementById("log_in_btn").innerHTML = "<a href=\"user.php\" class=\"btn btn-primary px-4\">Welcome ' . $_SESSION['auth_user']['FullName'] . '</a>";</script>';
            } else if (isset($_SESSION['auth_admin']['adminID'])) {
                echo '<script>document.getElementById("log_in_btn").innerHTML = "<a href=\"admin.php\" class=\"btn btn-primary px-4\">Admin</a>";</script>';
            } else {
                echo '<script>document.getElementById("log_in_btn").innerHTML = "<a href=\"sign_in.php\" class=\"btn btn-primary \">Log in</a>";</script>';
                echo '<script>document.getElementById("Sign_in_btn").innerHTML = "<a href=\"sign_up.php\" class=\"btn btn-warning  \">Sign Up</a>";</script>';
            }
            ?>

        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section mb-5" style="background-image: url('images/O5X8IS0.jpg'); height: 550px; ">
        <div class="container px-4">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6 text-center">
                    <h1 class="display-4">Welcome to NBA Jersey Shop</h1>
                    <p class="lead">Get ready to show your support with our authentic NBA jerseys. Explore our wide
                        range of jerseys featuring your favorite teams and players.</p>
                    <a href="product.php" class="btn btn-secondary btn-lg">Shop Now</a>
                </div>
                <div class="col-md-6 text-center">
                    <img src="images/hero-img.png" class="img-fluid" alt="NBA Jerseys">
                </div>
            </div>
        </div>
    </section>

    <!-- PHP code to fetch top 3 most sold products -->
    <?php


    // Assuming you have a database table named "products" with fields like "product_id", "name", "image", and "price"
    $sql = "SELECT * FROM product_table ORDER BY prod_sold DESC LIMIT 3";
    $result = mysqli_query($con, $sql);

    // Array to store fetched products
    $products = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }
    ?>
    <!-- HTML code to display product cards -->
    <div class="container mt-5" id="highlights">
        <h2 class="text-center mb-4">Highlights Products</h2>

        <section class="highlights-section">
            <div class="row">
                <?php foreach ($products as $product) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?php echo $product['prod_image']; ?>" class="card-img-top product-img mx-auto d-block" alt="<?php echo $product['prod_name']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $product['prod_name']; ?></h5>
                                <p class="card-text">Price: $<?php echo $product['prod_price']; ?></p>
                                <a href="product.php?id=<?php echo $product['prod_id']; ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
    <!-- About Section -->
    <section id="about" class="mt-5 text-dark pt-5 mb-5" style="background-image: url('images/wepik-export-20240420030838wTdh.png'); border:'1px solid black;'">
        <div class="container">
            <h2 class="text-center mb-3 ">About Us</h2>
            <div class="about-content d-flex justify-content-between ">
                <div class="about-image float-start pt-2 border-1 ">
                    <img src="./images/basketball-balls-net.jpg" alt="About Us Image" style="width: 400px;">
                </div>
                <div class="about-text mx-5 ">
                    <p class="">Welcome to NBA Jersey Shop, your ultimate destination for authentic NBA jerseys and
                        fan gear. Our passion for basketball and commitment to providing fans with high-quality
                        products inspired us to create this online store.</p>

                    <p>At NBA Jersey Shop, we offer a wide selection of jerseys representing your favorite NBA teams
                        and players. Whether you're a die-hard fan looking to show support for your team or a
                        collector seeking rare and vintage jerseys, we've got you covered.</p>

                    <p>Our mission is to provide NBA fans worldwide with an unparalleled shopping experience. We
                        source our jerseys from official NBA partners and licensed manufacturers to ensure authenticity
                        and quality. Your satisfaction is our top priority, and we strive to exceed your expectations
                        with every purchase.</p>

                    <p>Join thousands of satisfied customers who trust NBA Jersey Shop for their basketball apparel
                        needs. Explore our collection today and gear up to represent your team in style!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ContactUs-->
    <div class="container mt-5 mt-5 text-dark pt-5 mb-5">
        

        <section class="contact-section" id="contact">
        <h2 class="text-center mb-5">Contact Us</h2>
            <div class="row">
                <div class="col-lg-6">
                    <form action="submit_contact.php" method="post">
                        <div class="form-group">
                            <label for="name">Your Name:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Your Email:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Your Message:</label>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter your message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Submit</button>
                    </form>

                </div>
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div class="contact-info">
                        <h4 class="mb-3">Contact Information</h4>
                        <p><strong>Address:</strong> 123 Street PaloPalo, Bulacan, Philippines</p>
                        <p><strong>Email:</strong> KingBrand@gmail.com</p>
                        <p><strong>Phone:</strong> +63 9123456789</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5 ">
        <div class="container">
            <div class="row">
                <!-- Contact Information -->
                <div class="col-md-4">
                    <h4>Contact Information</h4>
                    <p><strong>Email:</strong> KingBrand@gmail.com</p>
                    <p><strong>Phone:</strong> +63 9123456789</p>
                    <p><strong>Address:</strong> 123 Street PaloPalo, Bulacan, Philippines</p>
                </div>

                <!-- Social Media Links -->
                <div class="col-md-4">
                    <h4>Social Media</h4>
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="#"  class="text-decoration-none text-light"><i class="fab fa-facebook"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="text-decoration-none text-light"><i class="fab fa-instagram"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="text-decoration-none text-light"><i class="fab fa-twitter"></i></a></li>
                    </ul>
                </div>

                <!-- Additional Links -->
                <div class="col-md-4 ">
                    <h4>Additional Links</h4>
                    <ul class="text-decoration-none ">
                        <li><a href="#" class="text-decoration-none text-light">FAQs</a></li>
                        <li><a href="#" class="text-decoration-none text-light">Shipping & Returns</a></li>
                        <li><a href="privacy_policy.php" class="text-decoration-none text-light">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <!-- Copyright Information -->
                    <p>&copy; King Brand 2024</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Bootstrap JS and jQuery (optional) -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>