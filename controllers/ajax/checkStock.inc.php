<?php
session_start();
require_once('../../vendor/autoload.php');
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();
require('../../functions/connection.inc.php');

try {

    $pid = $_POST['pid'];
    $sql = "SELECT SUM(qty) AS total_quantity FROM products_in_branch WHERE pid = :pid";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':pid', $pid);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $dbQty = $result['total_quantity'];
    echo $dbQty;

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
