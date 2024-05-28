<?php 
    include "connect.php";
    if(isset($_POST['btnsubmit'])){
        $img_loc = $_FILES['image']['tmp_name'];
        $img_name = $_FILES['image']['name'];
        $img_des = "profiles/".$img_name;
        move_uploaded_file($img_loc,'profiles/'.$img_name);
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);


        $sql = "INSERT INTO user_table (fullname, usename, userpassword, user_image) VALUES ('$_POST[fullname]', '$_POST[username]', '$_POST[password]', '$img_des')";
        $result = mysqli_query($con, $sql);
        echo"
        <script>
            alert('Added Successfully!');
            location.href='admin_user.php';
        </script>
        ";
    }
?>
