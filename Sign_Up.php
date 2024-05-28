<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link href="./css/main.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            background-color: #f8f9fa; /* Light background color */
        }
        body{
            background-image: url('./images/regiter_bg.jfif');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            font-family: Arial, sans-serif;
            color: #fff; /* Set text color to white */
        }
        .container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .register-form {
            width: 100%;
            max-width: 600px;
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
        .register-form h2 {
            font-size: 1.5rem; /* Smaller heading size */
            color: white; /* Blue heading color */
        }
        .register-form .form-label {
            color: #fff; /* Set label color to white */
        }
        .register-form .form-control {
            font-size: 0.9rem; /* Smaller input size */
            color: #fff; /* Set input text color to white */
            background-color: transparent; /* Transparent input background */
            border: 1px solid #ced4da; /* Added border */
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); /* Added box shadow */
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .register-form .form-control:focus,
        .register-form .form-control:hover {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .register-form .form-control::placeholder {
            color: #fff; /* Placeholder text color */
            opacity: 0.5; /* Placeholder text opacity */
        }
        .register-form .btn {
            font-size: 0.9rem; /* Smaller button text */
            background-color: #007bff; /* Blue button color */
            border-color: #007bff; /* Blue border color for button */
            width: 100%; /* Set width to 100% */
        }
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 0.9rem; /* Smaller back button text */
            background-color: #6c757d; /* Gray background color for back button */
            border-color: #6c757d; /* Gray border color for back button */
        }
        .input-group-text {
            display: flex;
            align-items: center;
        }
        .input-group-text img {
            width: 20px;
            height: auto;
            margin-right: 5px;
        }
        h2{
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="register-form">
        <h2 class="text-center mb-4">Register Form</h2>
        <form action="signup_code.php" method="post">
            <div class="row mb-3">
                <div class="col">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" required>
                </div>
                <div class="col">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" required>
                </div>
                <div class="col-2">
                    <label for="middleinitial" class="form-label">M.I.</label>
                    <input type="text" class="form-control" id="middleinitial" name="middleinitial" maxlength="1">
                </div>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary" name='submit' value='submit'>Submit</button>
            </div>
        </form>
    </div>
    <!-- Back button with icon -->
    <button class="btn btn-secondary back-button" onclick="goBack()">
        <i class="fas fa-arrow-left"></i> Back
    </button>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script>
    // JavaScript function to go back to the previous page
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>