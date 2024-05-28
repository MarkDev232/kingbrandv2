<nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container d-flex  ">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="./images/mainlogo.png" alt="NBA Jersey Shop Logo" style="height: 60px;" />
                <span>King Brand</span>
            </a>

            <!-- Toggler/collapsible Button -->
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
                        <a class="nav-link " href="product.php">Shop</a>
                    </li>
                </ul>
            </div>

            <!-- Sign-in Button -->
            <div class='mx-2' id="log_in_btn">
            </div>
            <div id="Sign_in_btn">
            </div>
            <?php
            if (isset($_SESSION['auth_user']['FullName'])) {
                $user_image = $_SESSION['auth_user']['ProfilePic'];
                echo '<script>document.getElementById("log_in_btn").innerHTML = "<a href=\"user.php\" class=\"btn btn-primary px-4\">' . $_SESSION['auth_user']['FullName'] . '</a>";</script>';
                
            } else if (isset($_SESSION['auth_admin']['adminID'])) {
                echo '<script>document.getElementById("log_in_btn").innerHTML = "<a href=\"admin.php\" class=\"btn btn-primary px-4\">Admin</a>";</script>';
            } else {
                echo '<script>document.getElementById("log_in_btn").innerHTML = "<a href=\"sign_in.php\" class=\"btn btn-primary \">Log in</a>";</script>';
                echo '<script>document.getElementById("Sign_in_btn").innerHTML = "<a href=\"sign_in.php\" class=\"btn btn-warning  \">Sign Up</a>";</script>';
            }
            ?>
        </div>
    </nav>