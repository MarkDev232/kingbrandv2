<?php
include "connect.php";
session_start();
if (!isset($_SESSION['auth_admin']['adminFullName'])) {
    echo "<script> alert('Please Login First'); location.href='index.php';</script>";
    exit();
}

// Check if sort order is set
$sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'default';

switch ($sortOrder) {
    case 'asc':
        $orderBy = 'ORDER BY prod_sold ASC';
        break;
    case 'desc':
        $orderBy = 'ORDER BY prod_sold DESC';
        break;
    default:
        $orderBy = '';
        break;
}

$sql = "SELECT * FROM product_table $orderBy";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/" type="image/png" sizes="16x16 32x32">

    <title>Products</title>
    <link rel="stylesheet" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style2.css">
   
    <link rel="stylesheet" href="css/dropdown.css">
    
    <style>
        .form-select-custom {
            padding: 0.375rem 1.75rem 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            background-color: #fff;
            background-image: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"%3E%3Cpath fill="none" stroke="%23343a40" stroke-linecap="round" stroke-miterlimit="10" d="M2 0L0 2h4zm0 5L0 3h4z"/%3E%3C/svg%3E');
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 8px 10px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .form-select-custom:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .dropdown-item:hover{
    color:white;
    background-color: #343a40;

}
    </style>
</head>

<body>
    <?php
    include('header.php');
    ?>

    <!-- Sidebar -->
    <div class="sidebar" style="width: 250px;">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="admin.php"><i class="fa fa-dashboard"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_user.php"><i class="fa fa-user"></i> Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_user_block.php"><i class="fa fa-user-slash"></i> Users Block</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_product.php"><i class="fa-brands fa-buffer"></i> Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-folder"></i> Category
                </a>
                <!-- Submenu for Category -->
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="update_jersey_category.php"><i class="fas fa-tshirt"></i> Jersey</a></li>
                    <li><a class="dropdown-item" href="update_year_category.php"><i class="far fa-calendar-alt"></i> Year</a></li>
                    <li><a class="dropdown-item" href="update_team_category.php"><i class="fas fa-users"></i> Team</a></li>
                </ul>

            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin-reports.php"><i class="fa fa-receipt"></i> Reports</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin-setting.php"><i class="fa fa-gear"></i> Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="log_out.php"><i class="fa-solid fa-power-off"></i> Logout</a>
            </li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <section class="container mt-5">
            <div class="main-container">
                <div class="header-title"></div>
                <div class="d-flex justify-content-start align-items-center mb-3">
                    <button class="btn btn-primary"><a href="admin_product_add.php" class="text-white text-decoration-none"><i class="fa-solid fa-plus"></i> Add Product</a></button>
                    <button type="button" class="btn btn-danger mx-3" id="deleteSelected"><i class="fa fa-trash"></i> Delete Selected</button>
                    <div>
                        <select id="sortOrder" class="form-select form-select-custom" style="width: auto;" onchange="sortProducts()">
                            <option value="default" <?= $sortOrder == 'default' ? 'selected' : '' ?>>Sort by</option>
                            <option value="asc" <?= $sortOrder == 'asc' ? 'selected' : '' ?>>Most Sold Ascending</option>
                            <option value="desc" <?= $sortOrder == 'desc' ? 'selected' : '' ?>>Most Sold Descending</option>
                        </select>
                    </div>
                </div>

                <div class="tables">
                    <table class="table text-center" style="font-size:
18px;">
                        <thead
                        class="table-dark">
                            <tr style="font-size:15px;
font-weight:bold;">
<th>List</th>
<th>Product_ID</th>
<th>Product_Img</th>
<th>Product_Name</th>
<th>Product_Category</th>
<th>Product_Price</th>
<th>Product_Qty</th>
<th>Product_Sold</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
                         if ($result) {
                             while ($row = mysqli_fetch_assoc($result)) {
                                 $id = $row['prod_id'];
                                 $img = $row['prod_image'];
                                 $name = str_replace('_', ' ', $row['prod_name']);
                                 $team = $row['prod_team'];
                                 $year = $row['prod_year'];
                                 $jersey = $row['prod_jersey'];
                                 $price = $row['prod_price'];
                                 $qty = $row['prod_qty'];
                                 $sold = $row['prod_sold'];
                                 echo '<tr>
                                     <td><input style="width: 20px;" type="checkbox" name="ids[]" value="' . $id . '"></td>
                                     <td>' . $id . '</td>
                                     <td><img src="' . $img . '" style="width:100px; height: 100px;" alt="Responsive image"></td>
                                     <td>' . $name . '</td>
                                     <td>
                                         <div class="col text-center"><span class="badge text-bg-success text-light">' . $team . '</span></div>
                                         <div class="col text-center"><span class="badge text-bg-warning text-light">' . $year . '</span></div>
                                         <div class="col text-center"><span class="badge text-bg-primary text-light">' . $jersey . '</span></div>
                                     </td>
                                     <td>$' . $price . '</td>
                                     <td>' . $qty . '</td>
                                     <td>' . $sold . '</td>
                                     <td>
                                         <div class="d-grid gap-2">
                                             <button class="btn btn-primary btn-sm"><a href="admin_product_update.php?updateid=' . $id . '" class="text-white text-decoration-none"><i class="fa fa-pencil-square"></i> Update</a></button>
                                             <button class="btn btn-danger btn-sm deleteBtn" data-id="' . $id . '"><i class="fa fa-trash"></i> Delete</button>
                                         </div>
                                     </td>
                                 </tr>';
                             }
                         }
                         ?>
</tbody>
</table>
</div>
</div>
</section>
</div><script>
    function sortProducts() {
        var sortOrder = document.getElementById('sortOrder').value;
        window.location.href = "admin_product.php?sortOrder=" + sortOrder;
    }

    var categoryBtn = document.querySelector('.sidebar .dropdown-toggle');
    var submenu = document.querySelector('.sidebar .dropdown-menu');
    categoryBtn.addEventListener('click', function(e) {
        submenu.classList.toggle('show');
    });
    window.addEventListener('click', function(e) {
        if (!categoryBtn.contains(e.target)) {
            submenu.classList.remove('show');
        }
    });

    document.getElementById('deleteSelected').addEventListener('click', function() {
        var checkedIds = document.querySelectorAll('input[name="ids[]"]:checked');
        if (checkedIds.length > 0) {
            var idsArray = Array.from(checkedIds).map(function(checkbox) {
                return checkbox.value;
            });
            var formData = new FormData();
            formData.append('ids', JSON.stringify(idsArray));
            fetch('admin_product_delete_selected.php', {
                method: 'POST',
                body: formData
            }).then(function(response) {
                return response.text();
            }).then(function(data) {
                alert(data);
                window.location.reload();
            }).catch(function(error) {
                console.error(error);
            });
        } else {
            alert('Please select at least one product to delete.');
        }
    });

    var deleteBtns = document.querySelectorAll('.deleteBtn');
    deleteBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this product?')) {
                var id = this.getAttribute('data-id');
                window.location.href = 'admin_product_delete.php?deleteid=' + id;
            }
        });
    });
</script>
</body>
</html>