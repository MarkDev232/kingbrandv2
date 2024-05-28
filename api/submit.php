<?php

$host = "localhost";
$username = "root";
$password = "";

try {
    //code...
    $conn =  new PDO("mysql:host=$host; dbname=crud_test", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    //throw $th;
    echo "Connetion failed: " . $e->getMessage();
}

if (isset($_POST['name']) && $_POST['name']!= "" && isset($_POST['department']) && $_POST['department']!= "" && isset($_POST['position']) && $_POST['position']!= "") {
    # code...
    $sql = "INSERT INTO student_info (name,department,position) VALUES('" . addslashes($_POST['name']) . "','" . addslashes($_POST['department']) . "','" . addslashes($_POST['position']) . "')";
    $conn->query($sql);
}
