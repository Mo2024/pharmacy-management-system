<?php
session_start();
require_once('../../vendor/autoload.php');
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();
require('../../functions/connection.inc.php');

try {

    $month = $_POST['month'];
    $year = $_POST['year'];
    $query = "SELECT * FROM orders WHERE DATE_FORMAT(STR_TO_DATE(orderDate, '%M %d, %Y'), '%Y-%m') = :year_month";
    $statement = $db->prepare($query);
    
    $yearMonth = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
    $statement->bindParam(':year_month', $yearMonth);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($results);

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
