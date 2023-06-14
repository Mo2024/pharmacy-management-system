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
        "SELECT YEAR(STR_TO_DATE(orderDate, '%M %d, %Y')) AS year, SUM(totalPrice) AS totalRevenue
        FROM orders
        GROUP BY YEAR(STR_TO_DATE(orderDate, '%M %d, %Y'));";
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


        $html .= '<h1>Sales Revenue Per Year</h1>';
        $html .= '<table>';
        $html .= '<tr><th>Year</th><th>Total Revenue</th></tr>';

        foreach ($results as $year) {
            $html .= '<tr>';
            $html .= '<td>' . $year['year'] . '</td>';
            $html .= '<td>' . $year['totalRevenue'] . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('total_revenue_per_year.pdf', ['Attachment' => false]);

    } else {
        $_SESSION['error'] = "Unauthorized user";
        header("Location: /pharmacy-management-system/mainpage.php");
    }
} else {
    $_SESSION['error'] = "Please make login";
    header("Location: /pharmacy-management-system/auth/signin.php");
}
