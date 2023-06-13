<?php
session_start();
require_once('../../vendor/autoload.php');
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();
require('../../functions/connection.inc.php');



use Dompdf\Dompdf;

// Sample data for demonstration

$query = 
"SELECT products.*, products_in_branch.*, branches.name as bname
FROM products
LEFT JOIN products_in_branch ON products.pid = products_in_branch.pid
LEFT JOIN branches ON products_in_branch.bid = branches.bid
ORDER BY products.pid DESC;";
$statement = $db->prepare($query);
$statement->execute();
$results = $statement->fetchAll(PDO::FETCH_ASSOC);

$dompdf = new Dompdf();

// Generate HTML content dynamically
$html = '<style>
            h1 {
                text-align: center;
            }
            h2 {
                color: #336699;
                margin-bottom: 10px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                padding: 8px;
                border: 1px solid #000;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
        </style>';

// $html = json_encode($results);

$html .= '<h1>Product List</h1>';

$currentPid = 'first';
foreach ($results as $product) {
    if($currentPid == 'first'){
        $html .= '<h2>' . $product['bname'] . '</h2>';
        
        $html .= '<table>';
        $html .= '<tr><th>Branch</th><th>Quantity</th></tr>';
        $currentPid = $product['pid'];
    }else if($currentPid !== $product['pid']){
        $html .= '</table>';
        
        $html .= '<h2>' . $product['name'] . '</h2>';
        
        $html .= '<table>';
        $html .= '<tr><th>Branch</th><th>Quantity</th></tr>';
        $currentPid = $product['pid'];
    }else{
        $html .= '<tr>';
        $html .= '<td>' . $product['name'] . '</td>';
        $html .= '<td>' . $product['qty'] . '</td>';
        $html .= '</tr>';
    }
    
}
// $html .= '</table>';

// Set the HTML content for the PDF
$dompdf->loadHtml($html);

// (Optional) Set the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the PDF
$dompdf->render();

// Output the PDF as a file (downloadable)
$dompdf->stream('product_list.pdf', ['Attachment' => false]);