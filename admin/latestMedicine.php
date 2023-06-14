<?php
session_start();
require_once('../vendor/autoload.php');
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();
require('../functions/connection.inc.php');
use Dompdf\Dompdf;

if (isset($_SESSION['userId'])) {
    if ($_SESSION['role'] == 'admin') {
        $query = 
        "SELECT products.*, products_in_branch.*, branches.name AS bname
        FROM products
        LEFT JOIN products_in_branch ON products.pid = products_in_branch.pid
        LEFT JOIN branches ON products_in_branch.bid = branches.bid
        WHERE products.isDeleted = 0
        ORDER BY products.pid DESC;";
        $statement = $db->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $dompdf = new Dompdf();

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
                        width: 50%; /* Set column width to 50% */
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                </style>';


        $html .= '<h1>Product List</h1>';

        $currentPid = 'first';
        foreach ($results as $product) {
            if ($currentPid === 'first') {
                $html .= '<h2>' . $product['name'] . '</h2>';
                $html .= '<table>';
                $html .= '<tr><th>Branch</th><th>Quantity</th></tr>';
                $currentPid = $product['pid'];
            } else if ($currentPid !== $product['pid']) {
                $html .= '</table>';
                $html .= '<h2>' . $product['name'] . '</h2>';
                $html .= '<table>';
                $html .= '<tr><th>Branch</th><th>Quantity</th></tr>';
                $currentPid = $product['pid'];
            }

            if(!is_null($product['bid']) && !is_null($product['qty'])){
                $html .= '<tr>';
                $html .= '<td>' . $product['bname'] . '</td>';
                $html .= '<td>' . $product['qty'] . '</td>';
                $html .= '</tr>';
            }
        }
        $html .= '</table>';
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('product_list.pdf', ['Attachment' => false]);

    } else {
        $_SESSION['error'] = "Unauthorized user";
        header("Location: /pharmacy-management-system/mainpage.php");
    }
} else {
    $_SESSION['error'] = "Please make login";
    header("Location: /pharmacy-management-system/auth/signin.php");
}
