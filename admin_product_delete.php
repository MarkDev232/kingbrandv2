<?php
include "connect.php";
session_start();
if(isset($_GET['deleteid'])){
    $id =$_GET['deleteid'];

    $sql = "delete from product_table where prod_id=$id";
    $result = mysqli_query($con, $sql);
    echo"
    <script>
        alert('Deleted Successfully!');
        location.href='admin_product.php';
    </script>
    ";
}
?>