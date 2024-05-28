<?php
include('connect.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NBA Jersey Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Custom CSS file -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet"> <!-- Font Awesome -->
    <style>
        /* Hide carousel controls by default */
        .carousel-control {
            display: none;
        }

        /* Show carousel controls on hover */
        #featuredCarousel:hover .carousel-control {
            display: block;
        }

        /* Style carousel controls */
        .carousel-control {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            color: #fff;
            font-size: 20px;
            line-height: 40px;
            text-align: center;
            opacity: 0.5;
            transition: opacity 0.3s ease;
        }

        .carousel-control:hover {
            opacity: 1;
        }

        .carousel-control i {
            margin-top: 2px; /* Adjust icon position */
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
                        <a class="nav-link " href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="product.php">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#highlights">Highlights</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="my_storyboard.php">My StoryBoard</a>
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
                echo '<script>document.getElementById("Sign_in_btn").innerHTML = "<a href=\"sign_in.php\" class=\"btn btn-warning  \">Sign Up</a>";</script>';
            }
            ?>

        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h2 class="mb-4">Story Board</h2>
                <!-- Featured Products Carousel -->
                <div id="featuredCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="storyboard_img/admin.png" class="d-block w-100" alt="Admin">
                        </div>
                        <div class="carousel-item">
                            <img src="storyboard_img/user.png" class="d-block w-100" alt="User">
                        </div>
                        <div class="carousel-item">
                            <img src="storyboard_img/guest.png" class="d-block w-100" alt="Guest">
                        </div>
                        <!-- Add more carousel items as needed -->
                    </div>
                    <button class="carousel-control-prev position-absolute " type="button" data-bs-target="#featuredCarousel" data-bs-slide="prev">
                        <i class="fas fa-chevron-left w-100 "></i>
                    </button>
                    <button class="carousel-control-next position-absolute" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer mt-auto py-3 bg-dark">
        <div class="container text-white">
            <span>&copy; 2024 NBA Jersey Shop. All rights reserved.</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
