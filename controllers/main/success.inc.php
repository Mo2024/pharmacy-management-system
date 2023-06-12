<?php 
require('functions/mailer.inc.php');
if(isset($_SESSION['userId'])){
    if(isset($_GET['orderId'])){
        $query = 
        "SELECT orders.*, users.fName, users.email, addresses.*
        FROM orders
        INNER JOIN users ON orders.uid = users.uid
        INNER JOIN addresses ON users.uid = addresses.uid
        WHERE orders.oid = ?";
        $statement = $db->prepare($query);
        $statement->execute([$_GET['orderId']]);
        $row = $statement->fetch();

        $poidQuery = 
        "SELECT products.*, products_in_order.qty 
        FROM products_in_order
        INNER JOIN products ON products_in_order.pid = products.pid
        WHERE products_in_order.oid = ?";
        $statement = $db->prepare($poidQuery);
        $statement->execute([$_GET['orderId']]);        
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        $recipientEmail = $row['email'];
        $subject = 'Order Successfull!';
        $body = 'Order No '.$row['oid'].' has been placed!';

        $message->setTo($recipientEmail);
        $message->setSubject($subject);
        $message->setBody($body);
        $mailer->send($message);

    }else{
        $_SESSION['error'] = "You must make an order!";
        header("Location: /pharmacy-management-system/mainpage.php");
    }
    
}else{
    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    setcookie("redirect", $url,0,'/');
    header("Location: /pharmacy-management-system/auth/signin.php");
}

?>