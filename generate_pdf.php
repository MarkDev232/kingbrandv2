<?php
require_once('tcpdf/tcpdf.php');
include "connect.php";

// Initialize start and end date variables
$startDate = ''; // Initialize with empty string
$endDate = ''; // Initialize with empty string

// Check if start_date and end_date are set in the GET request
if (isset($_GET['start_date']) && isset($_GET['end_date']) && $_GET['start_date'] != '') {
    // Assign start and end dates from GET request
    $startDate = $_GET['start_date'];
    $endDate = $_GET['end_date'];

    // Construct the SQL query with date filtering
    $sql = "SELECT * FROM transaction WHERE trans_date BETWEEN '$startDate' AND '$endDate'";
} else {
    // Construct the SQL query without date filtering
    $sql = "SELECT * FROM transaction";
}

// Fetch data from the database
$result = mysqli_query($con, $sql);

// Initialize TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Transaction Report');
$pdf->SetSubject('Transaction Report');
$pdf->SetKeywords('TCPDF, PDF, transaction, report');

// Set custom header data
$pdf->SetHeaderData('./images/king.png', 100, 'King Brand', 'Transaction Report', array('start_date' => $startDate, 'end_date' => $endDate));

// Set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Add a page
$pdf->AddPage();

// Fetch data from the database
$result = mysqli_query($con, $sql);

// Initialize total sum variable
$totalSum = 0;

// Set some content to display
$html = '<h1 style="margin-bottom: 20px;">Transaction Report</h1>';

// Add start and end dates
$html .= '<p><strong>Start Date:</strong> ' . $startDate . '<br>';
$html .= '<strong>End Date:</strong> ' . $endDate . '</p>';

$html .= '<table cellpadding="5" cellspacing="0" border="1">';
$html .= '<thead><tr style="background-color: #000; color: #fff;">
<th>ID</th>
<th>User ID</th>
<th>Product ID</th>
<th>Product Name</th>
<th>Product Price</th>
<th>Product Qty</th>
<th>Date</th>
<th>Total</th>
</tr></thead>';
$html .= '<tbody>';

// Fetch data and format it into HTML table rows
while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr>';
    $html .= '<td>' . $row['trans_id'] . '</td>';
    $html .= '<td>' . $row['trans_userid'] . '</td>';
    $html .= '<td>' . $row['trans_product_id'] . '</td>';
    $html .= '<td>' . $row['trans_product_name'] . '</td>';
    $html .= '<td>' . $row['trans_product_price'] . '</td>';
    $html .= '<td>' . $row['trans_prodcut_qty'] . '</td>';
    $html .= '<td>' . $row['trans_date'] . '</td>';
    $html .= '<td>' . $row['trans_total'] . '</td>';

    // Add transaction total to the total sum
    $totalSum += $row['trans_total'];

    $html .= '</tr>';
}

$html .= '</tbody>';

// Display total sum in the table footer
$html .= '<tfoot>';
$html .= '<tr>';
$html .= '<td colspan="7"><strong>Total Sum</strong></td>';
$html .= '<td>' . $totalSum . '</td>';
$html .= '</tr>';
$html .= '</tfoot>';

$html .= '</table>';

// Write the HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('transaction_report.pdf', 'I');
?>
