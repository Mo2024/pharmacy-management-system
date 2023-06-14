<?php
session_start();
require_once('../../../vendor/autoload.php');
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__.'/../../../');
$dotenv->load();
require('../../../functions/connection.inc.php');
require('../../../functions/functions.inc.php');

$ids = $_POST['ids'];
$ids = explode("#", $ids);

$pid = $ids[0]; 
$bid = $ids[1]; 
$stmt = $db->prepare("DELETE FROM products_in_branch WHERE pid = ? AND bid = ?");
if($_SESSION['bid'] == $bid){
    if($stmt->execute([$pid, $bid])){
        echo "true";
    }
}else{
    echo 'notBranch';
}
