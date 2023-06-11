<?php 
require('../../functions/functions.inc.php');
require("../../partials/regex.inc.php");
if(isset($_SESSION['userId'])){
    if($_SESSION['role'] == "pharmacist"){
        if(isset($_GET['orderId'])){
            $oid = $_GET['orderId'];
            $oidQuery = 
            "SELECT orders.*, users.fName, addresses.*
            FROM orders
            INNER JOIN users ON orders.uid = users.uid
            INNER JOIN addresses ON users.uid = addresses.uid
            WHERE orders.oid = '$oid';";
            $result = $db->query($oidQuery);
            $row = $result->fetch();

            $poidQuery = 
            "SELECT products.*, products_in_order.qty 
            FROM products_in_order
            INNER JOIN products ON products_in_order.pid = products.pid
            WHERE products_in_order.oid = '$oid';";
            $result = $db->query($poidQuery);
            $products = $result->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $_SESSION['error'] = "Choose a valid Order";
            header("Location: /pharmacy-management-system/pharmacist/manageOrders/ordersList.php");
        }

        

    }else{
        $_SESSION['error'] = "Unauthorized user";
        header("Location: /pharmacy-management-system/mainpage.php");
    }
    
}else{
    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    setcookie("redirect", $url,0,'/');
    header("Location: /pharmacy-management-system/auth/signin.php");
}

?>