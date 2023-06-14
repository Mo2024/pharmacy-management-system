<?php

if(isset($_GET['productId'])){
    $query = "select * from products where pid = ?";
    $statement = $db->prepare($query);
    $statement->execute([$_GET['productId']]);
    $product = $statement->fetch();
}else{
    $_SESSION['error'] = "Choose a valid product";
    header("Location: /pharmacy-management-system/mainpage.php");
    exit();
}

?>