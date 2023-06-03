<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    require('../functions/functions.inc.php');
    require('../partials/regex.inc.php');

    $uid = $_POST['uid'];
    $formPassword = $_POST['password'];

    if($uid == ''){
        $_SESSION['error'] = "You must enter your username";
        header("Location: /pharmacy-management-system/auth/signin.php");
    } else if($formPassword == ''){
        $_SESSION['error'] = "You must enter a password";
        header("Location: /pharmacy-management-system/auth/signin.php?uid=".$uid);
    }else if(preg_match($usernameReg, $uid) && preg_match($passwordReg, $formPassword)){
        $uidQuery = "SELECT * FROM users WHERE BINARY username = '$uid'";
        $result = $db->query($uidQuery);
        if ($row = $result->fetch()) {
            if (password_verify($formPassword, $row['hash'])) {
                //password match and login in user
                
                
                $_SESSION["userId"] = $row['uid'];
                $_SESSION["role"] = $row['type'];
                $_SESSION["username"] = $row['username'];
                
                if(isset($_POST['rememberMe']) && $_POST['rememberMe'] == 'rememberMe'){
                    $data = $_SESSION["userId"].'#'.$_SESSION["username"];
                    $data = base64_encode($data);
                    setcookie("session", $data,time() + 604800, '/', '', true, true);
                }
                
                if(!isset($_COOKIE["redirect"])){
                    $_SESSION['success'] = "Login Successful";
                    header("Location: /pharmacy-management-system/mainpage.php");
                }else{
                    header("Location: ".$_COOKIE["redirect"]);
                    setcookie ("redirect", $redirectUrl, time() - 3600,'/');
                }
                die();  
            }
            else{
                //Incorrect password
                $_SESSION['error'] = "Incorrect Password";
                header("Location: /pharmacy-management-system/auth/signin.php?uid=".$uid);
    
            }
        }
        else{
            //User does not exist
            $_SESSION['error'] = "Username does not exist";
            header("Location: /pharmacy-management-system/auth/signin.php");
        }

    }else if(!preg_match($usernameReg, $uid)){
        //invalid username
        $_SESSION['error'] = "Invalid Username";
        header("Location: /pharmacy-management-system/auth/signin.php?uid=".$uid);
    }else if(!preg_match($passwordReg, $formPassword)){
        //invalid password
        $_SESSION['error'] = "Invalid Password";
        header("Location: /pharmacy-management-system/auth/signin.php?uid=".$uid);
    }
}
?>