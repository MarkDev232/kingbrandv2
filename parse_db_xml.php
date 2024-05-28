<?php

// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'king_branddb';
$table = 'product_table';

// Connect to MySQL
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch data from the table
$query = "SELECT * FROM $table";
$result = $conn->query($query);

// Create XML object
$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<?xml-stylesheet type="text/xsl" href="product.xsl"?>' . "\n" . '<products/>');


// Iterate through the result set
while ($row = $result->fetch_assoc()) {
    $item = $xml->addChild('product');
    foreach ($row as $key => $value) {
        $item->addChild($key, htmlspecialchars($value));
    }
}

// Save XML to a file
$xml->asXML('product.xml');

// Close connection
$conn->close();


?>
