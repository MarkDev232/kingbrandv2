<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/main.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom styles for this template -->
    <style>
      body {
        background-image: url('./images/log_in_bg.jpg');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        font-family: Arial, sans-serif;
        color: #fff; /* Set text color to white */
      }

      .container {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
      }

      .form-container {
        width: 100%;
        max-width: 400px;
        padding: 30px;
        background-color: transparent;
  
        border-radius: 10px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        position: relative;
        border: 2px solid #ced4da; /* Added border */
        border-radius: 10px;
            background-color: rgba(0, 0, 0, 0.7); /* Transparent black background */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            border: 2px solid #8C6A5D; 
            color: white; /* Text color */
      }

      .form-signin {
        width: 100%;
      }

      .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 15px;
        font-size: 16px;
        border: 1px solid #ced4da; /* Added border */
        border-radius: 5px;
        margin-bottom: 20px;
        background-color: rgba(255, 255, 255, 0.7);
        color: #fff; /* Set text color to white */
        font-family: 'Roboto', sans-serif; /* Apply font to labels and input elements */
            color: white; /* Label text color */
      }

      .form-signin .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        background-color: rgba(255, 255, 255, 0.1); /* Transparent background for inputs */
            border: 1px solid #ced4da; /* Border color */
            color: white; /* Input text color */
      }

      .form-signin input[type="submit"] {
        margin-top: 20px;
        padding: 12px;
        font-size: 18px;
        border-radius: 5px;
        background-color: transparent;
        color: white;
        border: none;
        cursor: pointer;
      }

      .form-signin input[type="submit"]:hover {
        background-color: red;
      }

      .form-signin input[type="submit"]:focus {
        outline: none;
      }

      .forgot-password-link {
        text-decoration: none;
        color: #fff; /* Set text color to white */
      }

      .forgot-password-link:hover {
        text-decoration: underline;
      }

      .signup-link {
        color: #fff; /* Set text color to white */
      }

      .signup-link:hover {
        text-decoration: underline;
      }

      .back-icon {
        position: absolute;
        top: 10px;
        left: 10px;
        font-size: 24px;
        color: #007bff;
        cursor: pointer;
      }

      /* Added border to labels */
      .form-signin label {
        display: block;
        margin-bottom: 0.5rem;
        color: #fff; /* Set text color to white */
      }

      /* Added border to input boxes */
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        width: 100%;
        padding: 0.375rem 0.75rem;
        margin-bottom: 1rem;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        color: #1c1b1b; /* Set text color to white */
      }
    </style>
</head>
<body>
  <div class="container">
    <div class="form-container text-center">
      <i class="fas fa-arrow-left back-icon text-light " onclick="goBack()"></i>
      <form class="form-signin" method="POST" action="login_code.php">
        <h1 class="h3 mb-4 font-weight-normal text-center">Sign In</h1>
        <label for="inputUsername">Username</label>
        <input type="text" id="inputUsername" name="inputusername" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword">Password</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-secondary btn-block" name="submit" type="submit">Log In</button>
        <div class="text-center mt-3">
          <a href="forgot.php" class="forgot-password-link">Forgot password?</a>
        </div>
        <div class="text-center mt-3">
          <span>Don't have an account? </span><a href="Sign_Up.php" class="signup-link">Sign up</a>
        </div>
      </form>
    </div>
  </div>
  
  <!-- JavaScript for back button -->
  <script>
    function goBack() {
      location.href="index.php";
    }
  </script>
</body>
</html>
