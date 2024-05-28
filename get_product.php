<?php
// Include the connection file
include "connect.php";

// Fetch products from the database
$sql = "SELECT * FROM product_table";
$result = mysqli_query($con, $sql);

// Prepare the response as JSON
$response = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }
}

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
