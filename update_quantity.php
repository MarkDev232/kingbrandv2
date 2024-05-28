<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if all required parameters are present
    if (isset($_POST['productId']) && isset($_POST['action']) && isset($_POST['quantity']) && isset($_POST['cardId'])) {
        // Sanitize input data
        $productId = mysqli_real_escape_string($con, $_POST['productId']);
        $action = mysqli_real_escape_string($con, $_POST['action']);
        $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
        $cartID = mysqli_real_escape_string($con, $_POST['cardId']);

        // Update quantity in the database
        $sql = "UPDATE user_cart SET cart_prod_qty = $quantity WHERE card_id = $cartID AND cart_productId = $productId";
        if (mysqli_query($con, $sql)) {
            // Fetch updated product value from the database
            $productQuery = "SELECT prod_price FROM product_table WHERE prod_id = $productId";
            $productResult = mysqli_query($con, $productQuery);
            $productRow = mysqli_fetch_assoc($productResult);
            $productPrice = $productRow['prod_price'];
            $productValue = $productPrice * $quantity;

            // Return updated product value as JSON
            echo json_encode(['productValue' => $productValue]);
        } else {
            // If the update query fails, return an error message
            echo json_encode(['error' => 'Failed to update quantity']);
        }
    } else {
        // If any required parameter is missing, return an error message
        echo json_encode(['error' => 'Missing parameters']);
    }
} else {
    // If the request method is not POST, return an error message
    echo json_encode(['error' => 'Invalid request method']);
}
?>
