<?php 
    require('../partials/regex.inc.php');
    require('../functions/mailer.inc.php');
    require('../functions/functions.inc.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

        if(isset($_POST['uid'])){
            $userEmail = $_POST['uid'];
            if(!preg_match($emailReg, $userEmail)){
                $_SESSION['error'] = 'Invalid Email Address';
                header("Location: /pharmacy-management-system/auth/forgetPassword.php");
            }else{
                $uidQuery = "SELECT * FROM users WHERE BINARY email = :email";
                $stmt = $db->prepare($uidQuery);
                $stmt->bindParam(':email', $userEmail);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result) {
                    $pCode = random_int(100000, 999999);
                    
                    $insertQuery = "UPDATE users SET pcode = :pcode WHERE email = :email";
                    $stmt = $db->prepare($insertQuery);
                    $stmt->bindParam(':email', $userEmail);
                    $stmt->bindParam(':pcode', $pCode);
                    $stmt->execute();

                    
                    $recipientEmail = $userEmail;
                    $subject = 'Forget Password Verification Code';
                    $body = 'Your verification code is '.$pCode;
            
                    $message->setTo($recipientEmail);
                    $message->setSubject($subject);
                    $message->setBody($body);
                    $mailer->send($message);
                    
                    $_SESSION['display'] = 'pCode';
                    $_SESSION['forgetuid'] = $result['uid'];
                    $_SESSION['forgetusername'] = $result['username'];
                    header("Location: /pharmacy-management-system/auth/forgetPassword.php");
                } else {
                    $_SESSION['error'] = 'Email Does not exist';
                    header("Location: /pharmacy-management-system/auth/forgetPassword.php");                
                }
            }
        } 
        else if(isset($_POST['pcode'])){
            $pcode = $_POST['pcode'];
            if(!preg_match($pcodeReg, $pcode)){
                $_SESSION['error'] = 'Invalid Verification Code';
                $_SESSION['display'] = 'pCode';
                header("Location: /pharmacy-management-system/auth/forgetPassword.php");
            }else{
                $row = selectUser($_SESSION['forgetuid'], $db);
                if ($row['pcode'] == $pcode) {                    
                    $insertQuery = "UPDATE users SET pcode = :pcode WHERE uid = :uid";
                    $stmt = $db->prepare($insertQuery);
                    $stmt->bindParam(':uid', $decodedID);
                    $stmt->bindValue(':pcode', null);
                    $stmt->execute();
                    $_SESSION['display'] = 'pwd';
                    header("Location: /pharmacy-management-system/auth/forgetPassword.php");
                }else{                       
                    $_SESSION['error'] = 'Incorrect Verification Code';
                    $_SESSION['display'] = 'pCode';
                    header("Location: /pharmacy-management-system/auth/forgetPassword.php");
                }
            }
        }else if(isset($_POST['password1']) && isset($_POST['password2']) && isset($_SESSION['display']) && $_SESSION['display'] == 'pwd'){
            $pwd1 = $_POST['password1'];
            $pwd2 = $_POST['password2'];
            if(!preg_match($passwordReg, $pwd1) && !preg_match($passwordReg, $pwd2)){
                $_SESSION['error'] = 'Please make sure that the entered password has one special character, one small letter, one capital letter and at least 8 characters long';
                $_SESSION['display'] = 'pwd';
                header("Location: /pharmacy-management-system/auth/forgetPassword.php");
            }else{
                if($pwd1 == $pwd2){
                    $hash = password_hash($pwd1, PASSWORD_DEFAULT);
                    $insertQuery = "UPDATE users SET hash = :hash WHERE uid = :uid";
                    $stmt = $db->prepare($insertQuery);
                    $uid = $_SESSION['forgetuid'];
                    $stmt->bindParam(':uid', $uid);
                    $stmt->bindParam(':hash', $hash);
                    $stmt->execute();
                    $_SESSION['success'] = 'Password Successfully Updated';
                    $_SESSION['username'] = $_SESSION['forgetusername'];
                    $_SESSION['userId'] = $_SESSION['forgetuid'];
                    unset($_SESSION['display']);
                    unset($_SESSION['forgetuid']);
                    unset($_SESSION['forgetusername']);
                    header("Location: /pharmacy-management-system/mainpage.php");
                }else{
                    $_SESSION['error'] = 'Passwords do not match';
                    $_SESSION['display'] = 'pwd';
                    header("Location: /pharmacy-management-system/auth/forgetPassword.php");
                }
            }
        }
    }


    
?>