<?php
include('connect.php');

if (isset($_GET['cartid'])) {
    $cartIds = $_GET['cartid'];
    $cartIdArray = explode(',', $cartIds);

    foreach ($cartIdArray as $cartId) {
        // Retrieve data from user_cart table for the current cartId
        $sql = "SELECT * FROM user_cart WHERE card_id = $cartId";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            // Retrieve data from the user_cart row
            $cart_userId = $row['cart_userId'];
            $cart_prod_id = $row['cart_productId'];
            $cart_prod_qty = $row['cart_prod_qty'];

            // Insert into the transaction table
            $insertQuery = "INSERT INTO transaction (trans_userid, trans_product_id, trans_product_name, trans_product_price, trans_prodcut_qty, trans_total, trans_date) 
            VALUES ('$cart_userId', '$cart_prod_id', (SELECT prod_name FROM product_table WHERE prod_id = '$cart_prod_id'), (SELECT prod_price FROM product_table WHERE prod_id = '$cart_prod_id'), '$cart_prod_qty', (SELECT prod_price * '$cart_prod_qty' FROM product_table WHERE prod_id = '$cart_prod_id'), CURDATE())";
            mysqli_query($con, $insertQuery);

            // Update the product_table for sold quantity and quantity available
            $updateQuery = "UPDATE product_table SET prod_sold = prod_sold + $cart_prod_qty, prod_qty = prod_qty - $cart_prod_qty WHERE prod_id = '$cart_prod_id'";
            mysqli_query($con, $updateQuery);

            // Delete the item from user_cart table
            $deleteQuery = "DELETE FROM user_cart WHERE card_id = $cartId";
            mysqli_query($con, $deleteQuery);
        }
    }

    echo "
        <script>
            alert('Transaction Successful!');
            location.href='product.php';
        </script>";

} else {
    echo "Error: No cart ID provided.";
}
?>
