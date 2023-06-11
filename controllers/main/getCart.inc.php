<?php
session_start();
require_once('../../vendor/autoload.php');
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();
require('../../functions/connection.inc.php');
require('../../functions/functions.inc.php');
require("../../partials/regex.inc.php");


try {
    $cart = json_decode($_POST['cart'], true);
    if(empty($cart)){
        echo "empty";
    }else{
        $pids = array_column($cart, 'pid');
        $placeholders = implode(',', array_fill(0, count($pids), '?'));
        $query = "SELECT * FROM products WHERE pid IN ($placeholders)";
        $statement = $db->prepare($query);
        $statement->execute($pids);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($results);
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
