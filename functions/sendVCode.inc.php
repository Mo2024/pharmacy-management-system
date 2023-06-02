<?php 
    require('../partials/boilerplate.inc.php');
    require('../functions/functions.inc.php');
    $id = $_SESSION['userId'];
    $row = selectUser($id, $db);
    if(!$row['verified']){
        require('mailer.inc.php');
        session_start();
        $vCode = random_int(100000, 999999);
        $insertQuery = "UPDATE users SET vcode = :vcode WHERE uid = :uid";
        $stmt = $db->prepare($insertQuery);
        $stmt->bindParam(':uid', $id);
        $stmt->bindParam(':vcode', $vCode);
        $stmt->execute();
        $message->setTo($row['email']);
        $message->setSubject('Forget Password Verification Code');
        $message->setBody('Your verification code is '.$vCode);
        $mailer->send($message);
        $_SESSION['success'] = 'Verification Code Sent!';
        header("Location: /ITCS333-Project/profile/profile.php");
    }
?>