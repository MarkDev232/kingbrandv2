<?php
include "connect.php";
session_start();

        if(isset($_GET['ids'])){
            $id = implode(",",$_GET['ids']);
            $delete = "DELETE FROM product_table WHERE prod_id in($id)";
        mysqli_query($con, $delete);
        echo "
            <script>
                alert('Deleted Successfully!');
                window.location.href='admin_product.php';
            </script>
            ";
        }else{
            echo "
            <h2>There's no product selected</h2>
            <script>
                
                window.location.href='admin_product.php';
            </script>
            ";
        }
        
    
        
    
?>