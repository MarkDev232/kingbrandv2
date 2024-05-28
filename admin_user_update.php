<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['auth_admin']['adminID'])) {
    // Redirect to login page if not logged in
    echo "<script> alert('Please Login First'); location.href='login.php';</script>";
    exit();
}

$id = $_GET['updateid'];
$sql = "SELECT fullname, usename, userpassword FROM user_table WHERE id='$id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$fname = $row['fullname'];
$user = $row['usename'];
$pass = $row['userpassword'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Fname = $_POST['fullname'];
    $Uname = $_POST['username'];
    $Apass = $_POST['password'];

    if (isset($_POST['btnsubmit'])) {
        // Update data in database
        $sql1 = "UPDATE `user_table` SET `fullname`= '$Fname', `usename`= '$Uname', userpassword = '$Apass' WHERE id = '$id'";
        mysqli_query($con, $sql1);
        echo "
            <script>
                alert('User Updated !');
                location.href='admin_user.php';
            </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>

<body>
    <a href="admin_user.php" class="btn btn-danger mb-3"><i class="fas fa-arrow-left"></i> Back</a>
    <div class="container">
        <h2 class="mb-4">Edit User Details</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name:</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $fname ?>" required>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $user ?>" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $pass ?>" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" name="btnsubmit">Submit</button>
        </form>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>
