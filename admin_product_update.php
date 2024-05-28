<?php
include 'connect.php';
session_start();
$id = $_GET['updateid'];
$sql = "SELECT prod_name, prod_team, prod_jersey, prod_year, prod_price, prod_qty, prod_image FROM product_table WHERE prod_id='$id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$prod_name = $row['prod_name'];
$prod_team = $row['prod_team'];
$prod_jersey = $row['prod_jersey'];
$prod_year = $row['prod_year'];
$prod_price = $row['prod_price'];
$prod_qty = $row['prod_qty'];
$prod_image = $row['prod_image'];

// Function to replace spaces with underscores and underscores with spaces
function replaceSpacesUnderscores($str) {
    $str = str_replace(' ', '_', $str); // Replace spaces with underscores
    $str = str_replace('_', ' ', $str); // Replace underscores with spaces
    return $str;
}

// Apply function to product name and product jersey
$prod_name = replaceSpacesUnderscores($prod_name);
$prod_jersey = replaceSpacesUnderscores($prod_jersey);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prod_name = $_POST['productName'];
    $prod_team = $_POST['productTeam'];
    $prod_jersey = $_POST['productJersey'];
    $prod_year = $_POST['productYear'];
    $prod_price = $_POST['productPrice'];
    $prod_qty = $_POST['productQty'];

    if ($_FILES['file']['error'] != 4) { // Error code 4 means no file was uploaded
        $img_loc = $_FILES['file']['tmp_name'];
        $img_name = $_FILES['file']['name'];
        $img_des = "image_jersey/" . $img_name; // corrected path
        move_uploaded_file($img_loc, 'image_jersey/' . $img_name); // added forward slash (/)

        // Update the image in the database
        $query = "UPDATE product_table SET prod_image='$img_des' WHERE prod_id ='$id'";
        mysqli_query($con, $query);
    }

    // Apply function to product name and product jersey
    $prod_name = replaceSpacesUnderscores($prod_name);
    $prod_jersey = replaceSpacesUnderscores($prod_jersey);

    $query1 = "UPDATE product_table SET prod_name='$prod_name', prod_team = '$prod_team', prod_jersey='$prod_jersey', prod_year='$prod_year', prod_price='$prod_price', prod_qty='$prod_qty' WHERE prod_id ='$id'";
    mysqli_query($con, $query1);
    echo "<script>alert('Updated Successfully!');location.href='admin_product.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="admin_product.php" class="btn btn-danger mb-3"><i class="fas fa-arrow-left"></i> Back</a>
        <h2 class="mb-4">Update Product Details</h2>
        <hr>
        <div class="container-sm">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="productImage" class="form-label">Product Image:</label>
                    <input type="file" class="form-control" id="file" name="file">
                </div>
                <div class="mb-3">
                    <label for="productName" class="form-label">Product Name:</label>
                    <input type="text" class="form-control" id="productName" name="productName" value="<?php echo $prod_name; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="productTeam" class="form-label">Product Team:</label>
                    <input type="text" class="form-control" id="productTeam" name="productTeam" value="<?php echo $prod_team; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="productYear" class="form-label">Product Year:</label>
                    <input type="text" class="form-control" id="productYear" name="productYear" value="<?php echo $prod_year; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="productJersey" class="form-label">Product Jersey:</label>
                    <input type="text" class="form-control" id="productJersey" name="productJersey" value="<?php echo $prod_jersey; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="productPrice" class="form-label">Product Price:</label>
                    <input type="number" class="form-control" id="productPrice" name="productPrice" step="0.01" value="<?php echo $prod_price; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="productQty" class="form-label">Product Quantity:</label>
                    <input type="number" class="form-control" id="productQty" name="productQty" value="<?php echo $prod_qty; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary" name='btnsubmit'>Update Product</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
