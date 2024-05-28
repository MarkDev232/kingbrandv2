<?php
session_start();
include "connect.php";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $user_email = $_POST['email'];

    // Check if username already exists
    $duplicate_username_query = "SELECT * FROM user_table WHERE usename = '$username'";
    $duplicate_username_result = mysqli_query($con, $duplicate_username_query);

    // Check if email already exists
    $duplicate_email_query = "SELECT * FROM user_table WHERE user_email = '$user_email'";
    $duplicate_email_result = mysqli_query($con, $duplicate_email_query);

    if (mysqli_num_rows($duplicate_username_result) > 0) {
        echo "<script>alert('Username is Already Taken'); window.location.href='Sign_Up.php';</script>";
    } elseif (mysqli_num_rows($duplicate_email_result) > 0) {
        echo "<script>alert('Email is Already Taken'); window.location.href='Sign_Up.php';</script>";
    } else {
        $firstname = $_POST['firstname'];
        $middleinitial = $_POST['middleinitial'];
        $lastname = $_POST['lastname'];
        $fullname = $firstname . ' ' . $middleinitial . ' ' . $lastname;
        $password = $_POST['password'];
        $email = $_POST['email'];

        // Encrypt the password (optional)
        // $password = password_hash($password, PASSWORD_BCRYPT);

        $insert_query = "INSERT INTO user_table (fullname, usename, userpassword, user_image, user_email) 
                         VALUES ('$fullname', '$username', '$password', './images/default_image.png', '$user_email')";
        $query_run = mysqli_query($con, $insert_query);

        if ($query_run) {
            echo "<script>alert('Registration Successful.'); window.location.href='sign_in.php';</script>";
        } else {
            echo "<script>alert('Registration Failed'); window.location.href='register.php';</script>";
        }
    }
}
?>
