<?php 
if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])){
    require('../functions/functions.inc.php');
    require("../partials/regex.inc.php");
    $id = $_SESSION['userId'];

    $row = selectUser($id, $db);
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){
        
        if($_POST['newpwd1'] == '' || $_POST['newpwd2'] == ''){
            $_SESSION['error'] = "Password fields are empty";
            header("Location: /pharmacy-management-system/profile/updatePassword.php"); 
        } else{
            $newPwd = $_POST['newpwd1'];
            $confirmPwd = $_POST['newpwd2'];
                if($_POST['oldpwd'] == ''){
                    $_SESSION['error'] = "Current Password field is empty";
                    header("Location: /pharmacy-management-system/profile/updatePassword.php"); 
                }else{
                    $currentPwd = $_POST['oldpwd'];
                    if (password_verify($currentPwd, $row['hash'])) {
                        updatePassword($passwordReg, $newPwd, $confirmPwd, $id, $db, $currentPwd);
                    }else{
                        $_SESSION['error'] = "Incorrect current password";
                        header("Location: /pharmacy-management-system/profile/updatePassword.php"); 
                    }
                }
    
        }
    }   
}
else{
    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    setcookie("redirect", $url,0,'/');
    header("Location: /pharmacy-management-system/auth/signin.php");
    
}


?>