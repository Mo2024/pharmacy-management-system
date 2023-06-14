<?php
session_start();
require_once('../../../vendor/autoload.php');
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__.'/../../../');
$dotenv->load();
require('../../../functions/connection.inc.php');
require('../../../functions/functions.inc.php');

$ids = $_POST['ids'];
$ids = explode("%", $ids);

$pid = $ids[0]; 
$bid = $ids[1]; 
$qty = $_POST['qty'];
$stmt = $db->prepare("UPDATE products_in_branch SET qty = ? WHERE pid = ? AND bid = ?");
if($_SESSION['bid'] == $bid){
    if($qty > 0){
        if($stmt->execute([$qty, $pid, $bid])){
            echo "true";
        }
    }else if($qty <= 0){
        $stmt = $db->prepare("SELECT qty FROM products_in_branch  WHERE pid = ? AND bid = ?");
        $stmt->execute([$pid, $bid]);
        $row = $stmt->fetch();
        $qty = $row['qty'];
        echo  'rollBackQty'.$qty;
    }
}else{
    echo 'notBranch';
}

