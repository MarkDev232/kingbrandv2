<?php
session_start();
include('connect.php');

    if(isset($_SESSION['auth_admin']['adminID'])) {
        // Kung wala, ireredirect sa login page
        echo "<script> alert('Admin can't Buy product');
        window.location.href='product.php';</script>";
        exit();
       
    }
// Check if product ID is provided
// Retrieve data from URL parameters
$userID = isset($_GET['userID']) ? $_GET['userID'] : '';
$productID = isset($_GET['productID']) ? $_GET['productID'] : '';
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : '';
$total = isset($_GET['total']) ? $_GET['total'] : '';

$sql = "SELECT * FROM product_table WHERE prod_id = '$productID'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $id = $row['prod_id'];
    $img = $row['prod_image'];
    // Replace underscores with spaces in the product name
    $name = str_replace('_', ' ', $row['prod_name']);
    $team = $row['prod_team'];
    $year = $row['prod_year'];
    $jersey = $row['prod_jersey'];
    $price = $row['prod_price'];
    $qty = $row['prod_qty'];
    $sold = $row['prod_sold'];
}

$new_qty = $qty - $quantity;
$new_sold = $sold + 1;
$sql2 = "UPDATE product_table 
         SET prod_qty = $new_qty, prod_sold = $new_sold
         WHERE prod_id = $productID";

if(mysqli_query($con, $sql2)){
    $sql3 = "INSERT INTO transaction
    (trans_userid, trans_product_id, trans_product_name, trans_product_price, trans_prodcut_qty, trans_total, trans_date) 
    VALUES 
    ($userID, $productID, '$name', $price, $quantity, $total, CURDATE())";
    if(mysqli_query($con, $sql3)){
        echo "
        <script>
            alert('Transaction Successful!');
            location.href='product.php';
        </script>";
    }
}
?>
