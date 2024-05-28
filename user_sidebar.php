<div class="col-md-2 col-xl-2 bg-dark text-white sidebar">
      <div class="sidebar-content">
        <div class="profile-pic mb-3" id="profile-pic">
          <?php
          if (isset($_SESSION['auth_user']['ProfilePic'])) {
            $user_image = $_SESSION['auth_user']['ProfilePic'];
            echo "<img src='{$user_image}' alt='Profile Picture' class='profile-pic'>";
          }
          ?>
        </div>
        <a href="user.php" class="btn btn-info btn-sm mb-2 text-start"><i class="fas fa-check-circle me-2"></i>Ordered</a>
        <a href="user_cart.php" class="btn btn-success btn-sm mb-2 active text-start"><i class="fas fa-shopping-cart me-2"></i>Cart</a>
        <a href="user_settings.php" class="btn btn-success btn-sm mb-2 active text-start"><i class="fas fa-shopping-cart me-2"></i>User Settings</a>

        <a href="log_out.php" class="btn btn-danger btn-sm text-start"><i class="fas fa-sign-out-alt me-2"></i>Log Out</a>
      </div>
    </div>