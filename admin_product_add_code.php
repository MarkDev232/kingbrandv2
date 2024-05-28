<?php
  include "connect.php";
  session_start();

  if(isset($_POST['submit'])){

                $img_loc = $_FILES['file']['tmp_name'];
                $img_name = $_FILES['file']['name'];
                $img_des = "image_jersey/".$img_name;
                move_uploaded_file($img_loc,'image_jersey/'.$img_name);
    
                $sql = "INSERT into product_table(prod_name,prod_team,prod_jersey,prod_year,prod_price,prod_qty,prod_sold,prod_image) values('$_POST[productName]','$_POST[productTeam]','$_POST[productJersey]','$_POST[productYear]','$_POST[productPrice]','$_POST[productQuantity]','0','$img_des')";
    
    
                mysqli_query($con, $sql);
                echo"
                <script>
                    alert('Added Successfully!');
                    location.href='admin_product.php';
                </script>
                ";
               
  }

?>