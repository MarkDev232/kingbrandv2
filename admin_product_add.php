<?php
include "connect.php";
session_start();

if (!isset($_SESSION['auth_admin']['adminFullName'])) {
    // If not logged in, redirect to the login page
    echo "<script> alert('Please Login First');
        location.href='sign_in.php';</script>";
    exit();
}

// Fetch team categories from the database
$sql = "SELECT descript FROM category WHERE cat_type = 'Team'";
$result = mysqli_query($con, $sql);
$teams = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $teams[] = $row['descript'];
    }
}

// Fetch year categories from the database
$sql_year = "SELECT descript FROM category WHERE cat_type = 'Year'";
$result_year = mysqli_query($con, $sql_year);
$years = [];
if ($result_year && mysqli_num_rows($result_year) > 0) {
    while ($row = mysqli_fetch_assoc($result_year)) {
        $years[] = $row['descript'];
    }
}

// Fetch jersey categories from the database
$sql_jersey = "SELECT descript FROM category WHERE cat_type = 'Jersey'";
$result_jersey = mysqli_query($con, $sql_jersey);
$jerseys = [];
if ($result_jersey && mysqli_num_rows($result_jersey) > 0) {
    while ($row = mysqli_fetch_assoc($result_jersey)) {
        $jerseys[] = $row['descript'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Product</title>
  <link rel="stylesheet" href="css/main.css">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
  <h2 class="mb-4">Add Product</h2>
  <hr>
  <form method="POST" action="admin_product_add_code.php" enctype="multipart/form-data">
    <div class="form-group">
      <label for="productImage">Product Image:</label>
      <input type="file" class="form-control-file" name="file">
    </div>
    <div class="form-group">
      <label for="productName">Product Name:</label>
      <input type="text" class="form-control" id="productName" name="productName">
    </div>
    <div class="form-group">
      <label for="productTeam">Product Team:</label>
      <select class="form-control" id="productTeam" name="productTeam">
        <option value="" selected disabled>Select Team</option>
        <?php foreach ($teams as $team): ?>
            <option value="<?php echo $team; ?>"><?php echo $team; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label for="productYear">Product Year:</label>
      <select class="form-control" id="productYear" name="productYear">
        <option value="" selected disabled>Select Year</option>
        <?php foreach ($years as $year): ?>
            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label for="productJersey">Product Jersey:</label>
      <select class="form-control" id="productJersey" name="productJersey">
        <option value="" selected disabled>Select Jersey</option>
        <?php foreach ($jerseys as $jersey): ?>
            <option value="<?php echo $jersey; ?>"><?php echo $jersey; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label for="productPrice">Product Price:</label>
      <input type="text" class="form-control" id="productPrice"  name="productPrice">
    </div>
    <div class="form-group">
      <label for="productQuantity">Product Quantity:</label>
      <input type="number" class="form-control" id="productQuantity" name="productQuantity">
    </div>
    <button type="submit" class="btn btn-primary" name='submit'>Submit</button>
  </form>
</div>

</body>
</html>
