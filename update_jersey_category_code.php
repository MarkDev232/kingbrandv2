<?php
include "connect.php";

// Check if category_id is set in the URL
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Fetch category details from the database
    $sql = "SELECT * FROM category WHERE cat_id = $category_id";
    $result = mysqli_query($con, $sql);

    // Check if query executed successfully
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $category_name = $row['descript'];
        $old_cat_name = $row['descript'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
        body {
            padding: 20px;
        }

        .form-container {
            max-width: 500px;
            margin: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update Category</div>
                    <div class="card-body">
                        <form action="update_category_process.php" method="POST">
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Category Name:</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $row['descript']; ?>" required>
                            </div>
                            <input type="hidden" name="old_cat_name" value="<?php echo $old_cat_name?>">
                            <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="category_list.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
    } else {
        // Category not found
        echo "Category not found.";
    }
} else {
    // Redirect to the category listing page if category_id is not set
    echo "Category ID not provided.";
}
?>
