<?php
include "connect.php";
session_start();

if (!isset($_SESSION['auth_admin']['adminID'])) {
    // Redirect to login page if not logged in
    echo "<script> alert('Please Login First'); location.href='login.php';</script>";
    exit();
}

// Check if the deleteid parameter is set in the URL
if (isset($_GET['deleteid'])) {
    $deleteid = $_GET['deleteid'];
    
    // Perform the deletion query
    $sql = "DELETE FROM user_table WHERE id = $deleteid";
    $result = mysqli_query($con, $sql);

    if ($result) {
        // Deletion successful, redirect to admin_user.php with success message
        echo "<script> alert('User deleted successfully'); location.href='admin_user.php';</script>";
        exit();
    } else {
        // Deletion failed, redirect to admin_user.php with error message
        echo "<script> alert('Error deleting user'); location.href='admin_user.php';</script>";
        exit();
    }
} else {
    // Redirect to admin_user.php if deleteid parameter is not set
    header("Location: admin_user.php");
    exit();
}
?>
