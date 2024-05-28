<?php
include('connect.php');
session_start();

if (!isset($_SESSION['auth_admin']['adminID'])) {
    // If not set, redirect to login page
    echo "<script> alert('Please Login First'); location.href='index.php';</script>";
    exit();
}

// Retrieve user data for the logged-in user
$admin_id = $_SESSION['auth_admin']['adminID'];
$query = "SELECT * FROM admin_info WHERE Admin_ID  = '$admin_id'";
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
    $fullName = $_POST['fullname'];
    $username = $_POST['usename'];
    $password = $_POST['userpassword'];

    // Handle profile picture upload
    if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] == 0) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["profilePic"]["name"]);
        move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_file);
        $profilePic = $target_file;

        // Update profile picture path in the database
        $update_query = "UPDATE admin_info SET Admin_Img='$profilePic' WHERE Admin_ID ='$admin_id'";
        mysqli_query($con, $update_query);

        // Update session variable with new profile picture path
        $_SESSION['auth_admin']['Profileadmin'] = $profilePic;
    } else {
        $profilePic = $user_data['Admin_Img'];
    }

    // Update query
    $update_query = "UPDATE admin_info SET Admin_Name='$fullName', Admin_Uname='$username', Admin_Pass='$password', Admin_Img='$profilePic' WHERE Admin_ID ='$userId'";
    if (mysqli_query($con, $update_query)) {
        // Update session variables with new user information
        $_SESSION['auth_admin']['adminFullName'] = $fullName;
        $_SESSION['auth_admin']['UserAdmin'] = $username;
        $_SESSION['auth_admin']['Password'] = $password;

        echo "<script> alert('User information updated successfully'); location.href='admin-setting.php';</script>";
    } else {
        echo "<script> alert('Error updating user information');</script>";
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
    <style>
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            margin-bottom: 20px;
        }

        .profile-pic-div {
            position: relative;
            display: inline-block;
        }

        .upload-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .user-details {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .password-toggle-btn {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    background-color: transparent;
    border: none;
    padding: 5px;
    cursor: pointer;
    outline: none;
}

.password-toggle-btn:focus {
    outline: none;
}

.password-toggle-btn i {
    color: #6c757d;
    font-size: 20px;
    transition: color 0.3s;
}

.password-toggle-btn:hover i {
    color: #495057;
}

    </style>
</head>

<body>
    <a href="admin.php" class="btn btn-secondary mt-5 mx-5"><i class="fas fa-arrow-left"></i> Back</a>
    <div class="container mt-5">

        <div class="user-details">
            <form method="POST" enctype="multipart/form-data">
                <div class="text-center">

                    <div class="profile-pic-div">
                        <img src="<?php echo $user_data['Admin_Img']; ?>" alt="
                        Profile Picture" class="profile-pic" id="profileImage">
                        <input type="file" name="profilePic" id="profilePicInput" style="display: none;" onchange="previewImage(event)">
                        <button type="button" class="upload-btn" onclick="document.getElementById('profilePicInput').click();">Change</button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $user_data['Admin_Name']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="usename" class="form-label">User Name</label>
                    <input type="text" class="form-control" id="usename" name="usename" value="<?php echo $user_data['Admin_Uname']; ?>" required>
                </div>
                <div class="mb-3 position-relative">
                    <label for="userpassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="userpassword" name="userpassword" value="<?php echo $user_data['Admin_Pass']; ?>" required>
                    <button type="button" class="password-toggle-btn" onclick="togglePassword()">
    <i id="passwordToggleIcon" class="fas fa-eye"></i>
</button>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div><!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0-alpha1/js/bootstrap.min.js"></script>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('profileImage');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function togglePassword() {
            var passwordInput = document.getElementById("userpassword");
            var passwordToggleIcon = document.getElementById("passwordToggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordToggleIcon.classList.remove("fa-eye");
                passwordToggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                passwordToggleIcon.classList.remove("fa-eye-slash");
                passwordToggleIcon.classList.add("fa-eye");
            }
        }
    </script>