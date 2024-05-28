<?php
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ids = json_decode($_POST['ids']);

    if (!empty($ids)) {
        foreach ($ids as $id) {
            $sql = "DELETE FROM product_table WHERE prod_id = $id";
            mysqli_query($con, $sql);
        }
        echo "Selected products deleted successfully.";
    } else {
        echo "No products selected for deletion.";
    }
} else {
    echo "Invalid request.";
}
?>
