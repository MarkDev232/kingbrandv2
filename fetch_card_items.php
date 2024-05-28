<?php
include('connect.php');

if(isset($_GET['userID'])) {
    $userID = $_GET['userID'];

    $sql = "SELECT product_table.*, user_cart.cart_prod_qty FROM product_table 
            INNER JOIN user_cart ON product_table.prod_id = user_cart.cart_productId
            WHERE user_cart.cart_userId = $userID";

    $result = mysqli_query($con, $sql);

    $products = [];
    while($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }

    echo json_encode($products);
    exit;
} else {
    echo json_encode(["error" => "UserID not provided"]);
    exit;
}
?>
