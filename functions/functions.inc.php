<?php
    function updatePassword($passwordReg, $newPwd, $confirmPwd, $id, $db, $oldpwd){
        if(preg_match($passwordReg, $newPwd) && preg_match($passwordReg, $confirmPwd)){
            if ($newPwd == $confirmPwd){
                if($newPwd == $oldpwd){
                    $_SESSION['error'] = 'New and old password are the same';
                    header("Location: /pharmacy-management-system/profile/updatePassword.php"); 
                }else{
                    $newHash = password_hash($newPwd, PASSWORD_DEFAULT);
                    $updateQuery = "UPDATE users SET hash = '$newHash' WHERE uid = '$id'";
                    $result = $db->query($updateQuery);
                    $_SESSION['success'] = 'Password Updated';
                    header("Location: /pharmacy-management-system/profile/updatePassword.php"); 
                }
            } else{
                $_SESSION['error'] = 'New Passwords do not match';
                header("Location: /pharmacy-management-system/profile/updatePassword.php"); 
            }
    
            
        }else{
            $_SESSION['error'] = 'Make sure that Password has one special character, one small letter, one capital letter and at least 8 characters long';
            header("Location: /pharmacy-management-system/profile/updatePassword.php"); 
        }
    }

    function selectUser($id, $db){
        $idQuery = "SELECT * FROM users WHERE uid = '$id'";
        $result = $db->query($idQuery);
        return $result->fetch();
    }

    // Data is valid, proceed with saving and sending email
    function generateRandomPassword($length = 8) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $password .= $characters[$index];
        }
        return $password;
    }