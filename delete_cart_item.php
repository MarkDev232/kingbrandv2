<?php
include('connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get cart ID from POST request
    $cartID = $_POST['cartID'];

    // Delete the cart item from the user_cart table
    $sql = "DELETE FROM user_cart WHERE card_id = $cartID";

    if (mysqli_query($con, $sql)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($con)]);
    }
}
?>
