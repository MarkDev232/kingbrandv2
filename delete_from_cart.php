<?php
include('connect.php');

// Check if cartID is provided via POST
if (isset($_POST['cartID'])) {
  $cartID = $_POST['cartID'];

  // Delete the item from the user_cart table
  $deleteQuery = "DELETE FROM user_cart WHERE card_id = $cartID";
  $result = mysqli_query($con, $deleteQuery);

  if ($result) {
    // Item deleted successfully
    echo json_encode(['success' => true, 'cartID' => $cartID]);
  } else {
    // Error occurred while deleting
    echo json_encode(['success' => false, 'message' => 'Error deleting item from cart.']);
  }
} else {
  // cartID not provided
  echo json_encode(['success' => false, 'message' => 'cartID not provided.']);
}
?>
