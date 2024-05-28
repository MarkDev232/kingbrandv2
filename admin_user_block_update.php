<?php
include "connect.php"; // Include your database connection file

// Check if updateid is set in the URL
if(isset($_GET['updateid'])) {
    // Sanitize the input to prevent SQL injection
    $updateid = mysqli_real_escape_string($con, $_GET['updateid']);

    // Update the user_block table to unblock the user
    $sql = "DELETE FROM user_block WHERE user_id = '$updateid'";

    $result = mysqli_query($con, $sql);
    $sql2 = " UPDATE user_table SET login_attempts = 0 where id = '$updateid'";
    $result2 = mysqli_query($con, $sql2);
    if($result) {
        // Redirect back to admin_user_block.php after successful update
        header("Location: admin_user_block.php");
        exit();
    } else {
        // Handle the error if the update fails
        echo "Error updating user block status: " . mysqli_error($con);
    }
} else {
    // Redirect to admin_user_block.php if updateid is not set
    header("Location: admin_user_block.php");
    exit();
}
?>
