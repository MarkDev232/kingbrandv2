<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f0f0;
        }
        .container {
            margin-top: 100px;
        }
        .close-icon {
            width: 24px;
            height: 24px;
            fill: currentColor;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                <a href="sign_in.php" class="float-start text-decoration-none"><svg class="close-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 10.586L7.757 6.343a1 1 0 00-1.414 1.414L10.586 12l-4.243 4.243a1 1 0 001.414 1.414L12 13.414l4.243 4.243a1 1 0 001.414-1.414L13.414 12l4.243-4.243a1 1 0 00-1.414-1.414L12 10.586z"/></svg></a>

                    <h2 class="text-center mb-4">Forgot Password</h2>
                    <form action="password-reset-code.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="txtemail" class="form-label">Enter your email address</label>
                            <input type="email" class="form-control" id="txtemail" name="txtemail" placeholder="Enter email address">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg" name="submitforgot">Continue</button>
                        </div>
                    </form>
                    <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
