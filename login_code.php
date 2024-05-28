<?php
session_start();
include "connect.php";

if (isset($_POST['submit'])) {

    if (!empty(trim($_POST['inputusername'])) && !empty(trim($_POST['inputPassword']))) {
        $username = mysqli_real_escape_string($con, $_POST['inputusername']);
        $password = mysqli_real_escape_string($con, $_POST['inputPassword']);

        // Check user table first
        $user_query = "SELECT * FROM user_table WHERE usename='$username' LIMIT 1";
        $user_result = mysqli_query($con, $user_query);

        if (mysqli_num_rows($user_result) > 0) {
            $user_row = mysqli_fetch_array($user_result);

            // Check if user is blocked
            $block_check_query = "SELECT * FROM user_block WHERE user_id='{$user_row['id']}' LIMIT 1";
            $block_check_result = mysqli_query($con, $block_check_query);

            if (mysqli_num_rows($block_check_result) > 0) {
                echo "<script>
                    alert('Your account is blocked due to multiple failed login attempts.');
                    window.location.href='sign_in.php';
                    </script>";
                exit(0);
            }

            if ($user_row['userpassword'] === $password) {
                $_SESSION['authenticated'] = true;
                $_SESSION['auth_user'] = [
                    'ID' => $user_row['id'],
                    'FullName' => $user_row['fullname'],
                    'UserName' => $user_row['usename'],
                    'Password' => $user_row['userpassword'],
                    'ProfilePic' => $user_row['user_image']
                ];
                // Reset login attempts on successful login
                mysqli_query($con, "UPDATE user_table SET login_attempts = 0 WHERE usename = '$username'");
                echo "<script>
                    alert('You are Login Successfully!');
                    window.location.href='index.php';
                    </script>";
                exit(0);
            } else {
                $attempts = $user_row['login_attempts'] + 1;
                if ($attempts >= 3) {
                    // Block the user by inserting into the user_block table
                    mysqli_query($con, "INSERT INTO user_block (user_id,is_blocked) VALUES ('{$user_row['id']}','1')");
                    echo "<script>
                        alert('Your account is blocked due to multiple failed login attempts.');
                        window.location.href='sign_in.php';
                        </script>";
                } else {
                    mysqli_query($con, "UPDATE user_table SET login_attempts = $attempts WHERE usename = '$username'");
                    echo "<script>
                        alert('Invalid Username or Password. Please try again!');
                        window.location.href='sign_in.php';
                        </script>";
                }
                exit(0);
            }
        }

        // Check admin table
        $admin_query = "SELECT * FROM admin_info WHERE Admin_Uname='$username' LIMIT 1";
        $admin_result = mysqli_query($con, $admin_query);

        if (mysqli_num_rows($admin_result) > 0) {
            $admin_row = mysqli_fetch_array($admin_result);

            if ($admin_row['Admin_Pass'] === $password) {
                $_SESSION['authenticated'] = true;
                $_SESSION['auth_admin'] = [
                    'adminID' => $admin_row['Admin_ID'],
                    'adminFullName' => $admin_row['Admin_Name'],
                    'UserAdmin' => $admin_row['Admin_Uname'],
                    'Password' => $admin_row['Admin_Pass'],
                    'Profileadmin' => $admin_row['Admin_Img']
                ];
                // No need to reset login attempts for admins
                echo "<script>
                    alert('You are Login Successfully!');
                    window.location.href='index.php';
                    </script>";
                exit(0);
            } else {
                echo "<script>
                    alert('Invalid Username or Password. Please try again!');
                    window.location.href='sign_in.php';
                    </script>";
                exit(0);
            }
        }

        // If no user or admin found
        echo "<script>
            alert('Invalid Username or Password. Please try again!');
            window.location.href='sign_in.php';
            </script>";
        exit(0);
    }
}
?>
