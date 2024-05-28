<?php
session_start();
include('connect.php');

// Check if the user is logged in and has a cart
if (isset($_SESSION['auth_user']['ID'])) {
    $userId = $_SESSION['auth_user']['ID'];

    // Query to get the count of products in the user's cart
    $sql = "SELECT COUNT(*) AS count FROM user_cart WHERE cart_userId = $userId";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
        echo json_encode(['count' => $count]);
    } else {
        // Error occurred while fetching count
        echo json_encode(['count' => 0]);
    }
} else {
    // User is not logged in or has no cart
    echo json_encode(['count' => 0]);
}
?>
