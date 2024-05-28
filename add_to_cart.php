<?php
include('connect.php');
session_start();
if (isset($_SESSION['auth_user']['ID'])) {
    $userID = $_SESSION['auth_user']['ID'];
} else if (isset($_SESSION['auth_admin']['adminFullName'])) {
    echo "<script> alert('Admin cannot proceed with transactions');
    location.href='product.php';</script>";
    exit();
} else {
    echo "<script> alert('Please Login First');
    location.href='sign_in.php';</script>";
    exit();
}
$prod_id = $_GET['id'];

$sql = "SELECT * FROM product_table WHERE prod_id = $prod_id ";
$result = mysqli_query($con, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['prod_id'];
        $img = $row['prod_image'];
        $name = str_replace('_', ' ', $row['prod_name']);
        $team = $row['prod_team'];
        $year = $row['prod_year'];
        $jersey = $row['prod_jersey'];
        $price = $row['prod_price'];
        $qty = $row['prod_qty'];

        // Check if quantity is greater than 0 before adding to cart
        if ($qty <= 0) {
            echo "<script>alert('Product is out of stock. Cannot add to cart.');location.href='product.php';</script>";
            exit(); // Stop execution if quantity is 0 or less
        }

        $sql2 = "INSERT INTO user_cart(cart_userId, cart_productId, cart_prod_qty) VALUES($userID, $prod_id, 1)";
        if (mysqli_query($con, $sql2)) {
            echo "<script>location.href='product.php';</script>";
            exit();
        }
    }
}
?>
