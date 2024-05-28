<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = $_POST['category_id'];
    $new_category_name = $_POST['category_name'];
    $old_name = $_POST['old_cat_name'];
    // Update the category name in the database
    

    // Update the category name in the product_table
    $sql2 = "UPDATE product_table SET prod_year = '$new_category_name' WHERE prod_year = '$old_name'";
    $result2 = mysqli_query($con, $sql2);
    $sql = "UPDATE category SET descript = '$new_category_name' WHERE cat_id = $category_id";
    $result = mysqli_query($con, $sql);
    if ($result && $result2) {
        // Both updates successful
        echo "<script>alert('Category updated successfully');</script>";
        echo "<script>window.location.href = 'update_year_category.php';</script>";
    } else {
        // Update failed
        echo "<script>alert('Failed to update category');</script>";
        echo "<script>window.location.href = 'update_year_category.php';</script>";
    }
} else {
    // Redirect to the category listing page if accessed directly
    header("Location: update_year_category.php");
    exit();
}
?>
