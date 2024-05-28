<?php
require_once('TPCDF/TPCDF.php'); // Include TCPDF library

session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the product details from the form
    $productId = $_POST['product-id'];
    $productName = $_POST['product-name'];
    $productImage = $_POST['product-image'];
    $productPrice = $_POST['product-price'];
    $productQuantity = $_POST['product-quantity'];

    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Receipt');
    $pdf->SetSubject('Receipt');

    // Add a page
    $pdf->AddPage();

    // Set some content to display
    $content = "
    <h2>Receipt</h2>
    <p>ID: $productId</p>
    <p>Name: $productName</p>
    <p>Price: $productPrice</p>
    <p>Quantity: $productQuantity</p>
    ";

    // Write the HTML content to the PDF
    $pdf->writeHTML($content, true, false, true, false, '');

    // Output the PDF as a file named receipt.pdf
    $pdf->Output('receipt.pdf', 'F');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>