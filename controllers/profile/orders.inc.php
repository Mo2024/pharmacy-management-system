<?php 
require('../functions/functions.inc.php');
if(isset($_SESSION['userId'])){
    $query = "SELECT oid, orderDate, status FROM orders WHERE uid = ? ORDER BY oid DESC";
    $statement = $db->prepare($query);
    $statement->execute([$_SESSION['userId']]);
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
}else{
    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    setcookie("redirect", $url,0,'/');
    header("Location: /pharmacy-management-system/auth/signin.php");
}

?>