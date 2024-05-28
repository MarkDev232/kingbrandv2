<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .close-icon {
            display: inline-block;
            width: 24px;
            height: 24px;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="%23000" d="M19.12 5.88a1.3 1.3 0 0 0-1.85 0L12 10.15 7.73 5.88a1.3 1.3 0 0 0-1.85 1.85L10.15 12l-4.27 4.27a1.3 1.3 0 1 0 1.85 1.85L12 13.85l4.27 4.27a1.3 1.3 0 0 0 1.85-1.85L13.85 12l4.27-4.27a1.3 1.3 0 0 0 0-1.85z"/></svg>');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <a id="back-btn" href="sign_in.php" class="text-end text-dark text-decoration-none close-icon"></a>
                    <form action="password-reset-code.php" method="POST" class="forms" enctype="multipart/form-data">
                        <input type="hidden" name="password_token" value="<?php if(isset($_GET['token'])){echo $_GET['token'];} ?>">
                        <h2 class="text-center mb-4">Change Password</h2>
                        <div class="mb-3">
                            <label for="txtemail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="txtemail" name="txtemail" value="<?php if(isset($_GET['User_Email'])){echo $_GET['User_Email'];} ?>" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="txtpass" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="txtpass" name="txtpass" placeholder="Enter new password" required>
                        </div>
                        <div class="mb-3">
                            <label for="txtpass1" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="txtpass1" name="txtpass1" placeholder="Confirm password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg d-block w-100">Save Changes</button>
                        <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
