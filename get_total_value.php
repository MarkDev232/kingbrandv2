<?php
include('connect.php');
session_start();

// Retrieve user ID from session
$userID = $_SESSION['auth_user']['ID'];

// Fetch cart items for the current user
$sql = "SELECT SUM(prod_price * cart_prod_qty) AS totalValue FROM user_cart INNER JOIN product_table ON user_cart.cart_productId = product_table.prod_id WHERE user_cart.cart_userId = $userID";
$result = mysqli_query($con, $sql);

// Check if query was successful
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalValue = $row['totalValue'];
    
    // Return total value as JSON
    echo json_encode(['totalValue' => $totalValue]);
} else {
    // Handle error if query fails
    echo json_encode(['error' => 'Failed to fetch total value']);
}

// Close database connection
mysqli_close($con);
?>
