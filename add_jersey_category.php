<?php
include "connect.php";
session_start();
if (!isset($_SESSION['auth_admin']['adminFullName'])) {
    // If not logged in, redirect to the login page
    echo "<script> alert('Please Login First');
        location.href='sign_in.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categoryName = $_POST['category_name'];
    $categoryType = 'Jersey';

    if (!empty($categoryName)) {
        $sql = "INSERT INTO category (descript, cat_type) VALUES ('$categoryName', '$categoryType')";
        $result = mysqli_query($con, $sql);

        if ($result) {
            echo "<script>alert('Category added successfully'); location.href='update_jersey_category.php';</script>";
        } else {
            echo "<script>alert('Failed to add category');
            window.location.href('update_jersey_category.php')</script>";
        }
    } else {
        echo "<script>alert('Please enter a category name');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Jersey Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <div class="container mt-5">
        <a href="update_jersey_category.php" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <h2>Add Jersey Category</h2>
        <form method="post" action="">
            <div class="mb-3">
                <label for="categoryName" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="categoryName" name="category_name" required>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add Category</button>
        </form>
    </div>
</body>

</html>
