<?php
include('connect.php');

$teams = isset($_GET['teams']) ? $_GET['teams'] : [];
$jerseys = isset($_GET['jerseys']) ? $_GET['jerseys'] : [];
$years = isset($_GET['years']) ? $_GET['years'] : [];

$query = "SELECT * FROM product_table WHERE 1=1";

if (!empty($teams)) {
    $teams = array_map(function($team) use ($con) {
        return "'" . mysqli_real_escape_string($con, $team) . "'";
    }, $teams);
    $query .= " AND prod_team IN (" . implode(',', $teams) . ")";
}

if (!empty($jerseys)) {
    $jerseys = array_map(function($jersey) use ($con) {
        return "'" . mysqli_real_escape_string($con, $jersey) . "'";
    }, $jerseys);
    $query .= " AND prod_jersey IN (" . implode(',', $jerseys) . ")";
}

if (!empty($years)) {
    $years = array_map(function($year) use ($con) {
        return "'" . mysqli_real_escape_string($con, $year) . "'";
    }, $years);
    $query .= " AND prod_year IN (" . implode(',', $years) . ")";
}

$result = mysqli_query($con, $query);

$products = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}

echo json_encode($products);
?>
