<?php
session_start();
require_once('../../../vendor/autoload.php');
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__.'/../../../');
$dotenv->load();
require('../../../functions/connection.inc.php');
require('../../../functions/functions.inc.php');

$pid = $_POST['pid'];
$stmt = $db->prepare("UPDATE products SET isDeleted = 1 WHERE pid = ?");
if($stmt->execute([$pid])){
    $allowedExtensions = array('jpg', 'jpeg', 'png');
    $filepath = '../../public/products/' . $pid;
    if (file_exists($filepath . ".jpg")) {
        unlink($filepath . ".jpg");
    } else if (file_exists($filepath . ".png")) {
        unlink($filepath . ".png");
    } else if (file_exists($filepath . ".jpeg")) {
        unlink($filepath . ".jpeg");
    }
    echo "true";
}


?>
