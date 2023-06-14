<?php 
require('../functions/functions.inc.php');
require("../partials/regex.inc.php");

if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])){
    $id = $_SESSION['userId'];
    $idQuery = "SELECT * FROM addresses WHERE uid = ".$id."";
    $result = $db->query($idQuery);
    $row = $result->fetch();
    $building = $row['building'];
    $road = $row['road'];
    $block = $row['block'];
    $row = selectUser($id, $db);
    $email = $row['email'];
    $username = $row['username'];
    $fullname = $row['fName'];
    $number = $row['number'];
    $redirect = true;
    
    if (isset($_POST['submit'])){
        $username = $_POST['username'];
        $postEmail = $_POST['email'];
        $fullname = $_POST['fullname'];
        $number = $_POST['number'];
        $building = $_POST['building'];
        $road = $_POST['road'];
        $block = $_POST['block'];
        $redirect = true;

        $buildingValid = preg_match('/^[a-zA-Z0-9\s]+$/', $building);
        $roadValid = preg_match('/^[a-zA-Z0-9\s]+$/', $road);
        $blockValid = preg_match('/^[a-zA-Z0-9\s]+$/', $block); 

        if(!preg_match($emailReg,$postEmail)){
            $_SESSION['error'] = "Please make sure that the entered email is valid";
            header("Location: /pharmacy-management-system/profile/profile.php");   
        } else if(!preg_match($usernameReg,$username)){
            $_SESSION['error'] = "Please make sure that Username is 4 to 20 characters long, only contains alphabet letters and 0 to 9 numerics";
            header("Location: /pharmacy-management-system/profile/profile.php");   
        } else if(!preg_match($nameReg,$fullname)){
            $_SESSION['error'] = "Please make sure that the entered full name is entered properly";
            header("Location: /pharmacy-management-system/profile/profile.php");   
        }else if(!$buildingValid){
            $_SESSION['error'] = "Invalid Building";
            header("Location: /pharmacy-management-system/profile/profile.php");   
        } else if(!$roadValid){
            $_SESSION['error'] = "Invalid Road";
            header("Location: /pharmacy-management-system/profile/profile.php");   
        }else if(!$blockValid){
            $_SESSION['error'] = "Invalid Block";
            header("Location: /pharmacy-management-system/profile/profile.php");   
        }else {
            $usernameQuery = "SELECT * FROM users WHERE BINARY username = '$username'";
            $emailQuery = "SELECT * FROM users WHERE BINARY email = '$postEmail'";
    
            $usernameResult = ($db->query($usernameQuery)->rowCount());
            $emailResult = ($db->query($emailQuery)->rowCount());
    
            //Cecks if username or email already exist, else it inserts the values into the database
            if($usernameResult>0 && $username !== $row['username']){
                $_SESSION['error'] = 'Username already exists';
                header("Location: /pharmacy-management-system/profile/profile.php");   
            }
            else if($emailResult>0 && $postEmail !== $row['email']){
                $_SESSION['error'] = 'Email already exists';
                header("Location: /pharmacy-management-system/profile/profile.php");   
            }
            else{
                $db->beginTransaction();

                $updateQuery = "UPDATE users SET username = :username, email = :email, fName = :fName, number = :number WHERE uid = :uid";
                $stmt = $db->prepare($updateQuery);
                
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $postEmail);
                $stmt->bindParam(':fName', $fullname);
                $stmt->bindParam(':number', $number);
                $stmt->bindParam(':uid', $id);
                $stmt->execute();

                $updateQuery = "UPDATE addresses SET building = :building, road = :road, block = :block WHERE uid = :uid";
                $stmt = $db->prepare($updateQuery);
                
                $stmt->bindParam(':building', $building);
                $stmt->bindParam(':road', $road);
                $stmt->bindParam(':block', $block);
                $stmt->bindParam(':uid', $id);
                $stmt->execute();
                $db->commit();

                $_SESSION['success'] = 'User profile updated';
                header("Location: /pharmacy-management-system/profile/profile.php"); 
            }
        }
    } 
   
}else{
    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    setcookie("redirect", $url,0,'/');
    header("Location: /pharmacy-management-system/auth/signin.php");
    
}

?>