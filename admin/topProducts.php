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
        "SELECT p.name AS productName, COUNT(*) AS orderCount
        FROM products_in_order poi
        INNER JOIN products p ON poi.pid = p.pid
        WHERE p.isDeleted = 0
        GROUP BY p.name
        ORDER BY orderCount DESC;";
        $statement = $db->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $dompdf = new Dompdf();

        $html = '<style>
                    h1 {
                        text-align: center;
                    }
                    th {
                        color: #336699;
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


        $html .= '<h1>Top Products Ordered</h1>';
        $html .= '<table>';
        $html .= '<tr><th>Name</th><th>Number of Times Ordered</th></tr>';

        foreach ($results as $product) {
            $html .= '<tr>';
            $html .= '<td>' . $product['productName'] . '</td>';
            $html .= '<td>' . $product['orderCount'] . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('top_products.pdf', ['Attachment' => false]);

    } else {
        $_SESSION['error'] = "Unauthorized user";
        header("Location: /pharmacy-management-system/mainpage.php");
    }
} else {
    $_SESSION['error'] = "Please make login";
    header("Location: /pharmacy-management-system/auth/signin.php");
}
