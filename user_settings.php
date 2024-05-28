<?php
include('connect.php');
session_start();

if (!isset($_SESSION['auth_user']['ID'])) {
    // If not set, redirect to login page
    echo "<script> alert('Please Login First'); location.href='index.php';</script>";
    exit();
}

// Retrieve user data for the logged-in user
$userId = $_SESSION['auth_user']['ID'];
$query = "SELECT * FROM user_table WHERE id = '$userId'";
$result = mysqli_query($con, $query);

// Check if user data was retrieved
if (mysqli_num_rows($result) == 1) {
    $user_data = mysqli_fetch_assoc($result);
} else {
    echo "<script> alert('User not found'); location.href='index.php';</script>";
    exit();
}

// Update user information if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = mysqli_real_escape_string($con, $_POST['fullname']);
    $username = mysqli_real_escape_string($con, $_POST['usename']);
    $email = mysqli_real_escape_string($con, $_POST['useremail']);
    $password = mysqli_real_escape_string($con, $_POST['userpassword']);

    // Check if username or email already exists for another user
    $check_query = "SELECT * FROM user_table WHERE (usename='$username' OR user_email='$email') AND id != '$userId'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script> alert('Username or Email is already taken');</script>";
    } else {
        // Handle profile picture upload
        if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] == 0) {
            $target_dir = "images/";
            $target_file = $target_dir . basename($_FILES["profilePic"]["name"]);
            move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_file);
            $profilePic = $target_file;

            // Update profile picture path in the database
            $update_query = "UPDATE user_table SET user_image='$profilePic' WHERE id='$userId'";
            mysqli_query($con, $update_query);

            // Update session variable with new profile picture path
            $_SESSION['auth_user']['ProfilePic'] = $profilePic;
        } else {
            $profilePic = $user_data['user_image'];
        }

        // Update query
        $update_query = "UPDATE user_table SET fullname='$fullName', usename='$username', userpassword='$password', user_email='$email', user_image='$profilePic' WHERE id='$userId'";
        if (mysqli_query($con, $update_query)) {
            // Update session variables with new user information
            $_SESSION['auth_user']['FullName'] = $fullName;
            $_SESSION['auth_user']['UserName'] = $username;
            $_SESSION['auth_user']['Password'] = $password;
            $_SESSION['auth_user']['Email'] = $email;

            echo "<script> alert('User information updated successfully'); location.href='user_settings.php';</script>";
        } else {
            echo "<script> alert('Error updating user information');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            background-image: url('images/basketball-game-concept.jpg');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            color: white; /* Default text color */
        }
        .user-details {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            background-color: rgba(0, 0, 0, 0.7); /* Transparent black background */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            border: 2px solid #8C6A5D; 
            color: white; /* Text color */
        }
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f0f0f0; /* Light border color */
        }
        .upload-btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .upload-btn:hover {
            background-color: #0056b3;
        }
        .btn-back {
            margin-top: 11px;
            position: absolute;
            top: 10px;
            left: 15px;
        }
        .btn-update {
            background-color: #28a745;
            border-color: #28a745;
            width: 100%; /* Make the button fill the space */
        }
        .btn-update:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        hr {
            border: 1px solid #8C6A5D;
        }
        label, .form-control {
            font-family: 'Roboto', sans-serif; /* Apply font to labels and input elements */
            color: white; /* Label text color */
        }
        .form-control {
            background-color: rgba(255, 255, 255, 0.1); /* Transparent background for inputs */
            border: 1px solid #ced4da; /* Border color */
            color: white; /* Input text color */
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="user.php" class="btn btn-secondary btn-back"><i class="fas fa-arrow-left"></i> Back</a>
        <div class="user-details">
            <h2 class="text-center mb-4">SETTINGS</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="text-center mb-4 position-relative">
                    <img src="<?php echo $user_data['user_image']; ?>" alt="Profile Picture" class="profile-pic">
                    <input type="file" name="profilePic" id="profilePicInput" style="display: none;" onchange="previewImage(event)">
                    <label for="profilePicInput" class="upload-btn">Change</label>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $user_data['fullname']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="usename" class="form-label">User Name</label>
                    <input type="text" class="form-control" id="usename" name="usename" value="<?php echo $user_data['usename']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="useremail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="useremail" name="useremail" value="<?php echo $user_data['user_email']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="userpassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="userpassword" name="userpassword" value="<?php echo $user_data['userpassword']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary btn-update">Update</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0-alpha1/js/bootstrap.min.js"></script>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.querySelector('.profile-pic');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>
