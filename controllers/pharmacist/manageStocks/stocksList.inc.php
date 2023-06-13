<?php 
require('../../functions/functions.inc.php');
require("../../partials/regex.inc.php");
if(isset($_SESSION['userId'])){
    if($_SESSION['role'] == "pharmacist"){
        $query = "SELECT products.name, products.pid, products_in_branch.*  FROM products_in_branch INNER JOIN products ON products_in_branch.pid = products.pid WHERE isDeleted = 0 AND products_in_branch.bid = ?";
        $statement = $db->prepare($query);
        $statement->execute([$_SESSION['bid']]);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    }else{
        $_SESSION['error'] = "Unauthorized user";
        header("Location: /pharmacy-management-system/mainpage.php");
    }
    
}else{
    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    setcookie("redirect", $url,0,'/');
    header("Location: /pharmacy-management-system/auth/signin.php");
}
