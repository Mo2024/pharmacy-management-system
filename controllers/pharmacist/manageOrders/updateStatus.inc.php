<?php 
require('../../functions/functions.inc.php');
require('../../functions/mailer.inc.php');
require("../../partials/regex.inc.php");
if(isset($_SESSION['userId'])){
    if($_SESSION['role'] == "pharmacist"){
        if(isset($_GET['orderId'])){
            $oid = $_GET['orderId'];
            $oidQuery = "SELECT * FROM orders WHERE oid = '$oid'";
            $result = $db->query($oidQuery);
            $row = $result->fetch();

            if($row['status'] !== 'delivered'){
                if(isset($_POST['submit'])){
                    $oidQuery = "SELECT orders.*, users.email FROM orders INNER JOIN users ON orders.uid = users.uid WHERE oid = '$oid'";
                    $result = $db->query($oidQuery);
                    $row = $result->fetch();
                        $status = $_POST['status'];
                        $oid = $_POST['submit'];
            
                        $recipientEmail = $row['email'];
                        $subject = 'Order Status Update';
                        $body = '';
                        
                        $insertQuery = "UPDATE orders SET status = :status, dateDelivered = :dateDelivered  WHERE oid = :oid";
                        $stmt = $db->prepare($insertQuery);
                        $stmt->bindParam(':oid', $oid);
                        $null = null;
                        
                        if($status == 'processing' && $row['status'] == 'pending'){
                            $body = 'Your order No. '.$row['oid'].' has begined processing';
                            $stmt->bindParam(':dateDelivered', $null);
                        }else if($status == 'shipped'  && ($row['status'] == 'processing' || $row['status'] == 'pending')){
                            $body = 'Your order No. '.$row['oid'].' has been shipped';        
                            $stmt->bindParam(':dateDelivered', $null);
                        }else if($status == 'delivered' && ($row['status'] == 'shipped' || $row['status'] == 'processing' || $row['status'] == 'pending')){
                            $body = 'Your order No. '.$row['oid'].' has been delivered';
                            $dateDelivered = date("F d\, Y");
                            $stmt->bindParam(':dateDelivered', $dateDelivered);
                        }else{
                            $_SESSION['error'] = "Choose a valid status";
                            header("Location: /pharmacy-management-system/pharmacist/manageOrders/updateStatus.php?orderId=".$oid);
                        }
                        $stmt->bindParam(':status', $status);
                        $stmt->execute();
                        $message->setTo($recipientEmail);
                        $message->setSubject($subject);
                        $message->setBody($body);
                        $mailer->send($message);
                        $_SESSION['success'] = "Status Updated Successfully";
                        header("Location: /pharmacy-management-system/pharmacist/manageOrders/ordersList.php");
                        
                    }
            }else{
                $_SESSION['error'] = "Order already Delivered!";
                header("Location: /pharmacy-management-system/pharmacist/manageOrders/ordersList.php");
            }
            
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