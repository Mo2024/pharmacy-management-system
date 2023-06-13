<?php 
 require('../functions/functions.inc.php');
 require("../partials/regex.inc.php");
 echo "<script> const passwordRegex = ".$passwordReg."</script>";
 echo "<script> const emailRegex = ".$emailReg."</script>";
 echo "<script> const usernameRegex = ".$usernameReg."</script>";
 echo "<script> const fullnameRegex = ".$nameReg."</script>";
 echo "<script> const numberRegex = ".$idReg."</script>";
if (isset($_POST['submit'])) {
    

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $fullname = $_POST['fullname'];
    $number = $_POST['number'];
    $building = $_POST['building'];
    $road = $_POST['road'];
    $block = $_POST['block'];
    $dateCreated = date("F d\, Y");

    $buildingValid = preg_match('/^[a-zA-Z0-9\s]+$/', $building);
    $roadValid = preg_match('/^[a-zA-Z0-9\s]+$/', $road);
    $blockValid = preg_match('/^[a-zA-Z0-9\s]+$/', $block); 

    if(!preg_match($emailReg, $email)){
        $_SESSION['error'] = "Please make sure that the entered email is valid";
        header("Location: /pharmacy-management-system/auth/signup.php?email=".$email."&username=".$username."&fullname=".$fullname."&number=".$number."&road=".$road."&block=".$block."&building=".$building);   
    }
    else if(!preg_match($usernameReg, $username)){
        $_SESSION['error'] = "Please make sure that Username is 4 to 20 characters long, only contains alphabet letters and 0 to 9 numerics";
        header("Location: /pharmacy-management-system/auth/signup.php?email=".$email."&username=".$username."&fullname=".$fullname."&number=".$number."&road=".$road."&block=".$block."&building=".$building);   
    }
    else if(!preg_match($passwordReg, $password) && !preg_match($passwordReg, $password2)){
        $_SESSION['error'] = "Please make sure that the entered password has one special character, one small letter, one capital letter and at least 8 characters long";
        header("Location: /pharmacy-management-system/auth/signup.php?email=".$email."&username=".$username."&fullname=".$fullname."&number=".$number."&road=".$road."&block=".$block."&building=".$building);   
    }
    else if(!preg_match($nameReg, $fullname) ){
        $_SESSION['error'] = "Please make sure that the entered full name is entered properly";
        header("Location: /pharmacy-management-system/auth/signup.php?email=".$email."&username=".$username."&fullname=".$fullname."&number=".$number."&road=".$road."&block=".$block."&building=".$building);   
    }
    else if(!preg_match($idReg, $number) ){
        $_SESSION['error'] = "Please make sure that the entered number is entered properly";
        header("Location: /pharmacy-management-system/auth/signup.php?email=".$email."&username=".$username."&fullname=".$fullname."&number=".$number."&road=".$road."&block=".$block."&building=".$building);   
    }elseif (!$buildingValid) {
        $_SESSION['error'] = "Invalid building";
        header("Location: /pharmacy-management-system/auth/signup.php?email=".$email."&username=".$username."&fullname=".$fullname."&number=".$number."&road=".$road."&block=".$block."&building=".$building);   
    } elseif (!$roadValid) {
        $_SESSION['error'] = "Invalid road";
        header("Location: /pharmacy-management-system/auth/signup.php?email=".$email."&username=".$username."&fullname=".$fullname."&number=".$number."&road=".$road."&block=".$block."&building=".$building);   
    } elseif (!$blockValid) {
        $_SESSION['error'] = "Invalid block";
        header("Location: /pharmacy-management-system/auth/signup.php?email=".$email."&username=".$username."&fullname=".$fullname."&number=".$number."&road=".$road."&block=".$block."&building=".$building);   
    }else{
        if($password != $password2){
            $_SESSION['error'] = "Passwords do not match";
        header("Location: /pharmacy-management-system/auth/signup.php?email=".$email."&username=".$username."&fullname=".$fullname."&number=".$number."&road=".$road."&block=".$block."&building=".$building);   
        }else{
            
            $usernameQuery = "SELECT * FROM users WHERE BINARY username = '$username'";
            $emailQuery = "SELECT * FROM users WHERE BINARY email = '$email'";
            
            $usernameResult = ($db->query($usernameQuery)->rowCount());
            $emailResult = ($db->query($emailQuery)->rowCount());
            
            //Cecks if username or email already exist, else it inserts the values into the database
            if($usernameResult>0){
                $_SESSION['error'] = "Username already exists";
                header("Location: /pharmacy-management-system/auth/signup.php?email=".$email."&username=".$username."&fullname=".$fullname."&number=".$number."&road=".$road."&block=".$block."&building=".$building);   
            }
            else if($emailResult>0){
                $_SESSION['error'] = "Email already exists";
                header("Location: /pharmacy-management-system/auth/signup.php?email=".$email."&username=".$username."&fullname=".$fullname."&number=".$number."&road=".$road."&block=".$block."&building=".$building);   
            }
            else{

                $hash = password_hash($password, PASSWORD_DEFAULT);
                $db->beginTransaction();

                $sql = "INSERT INTO users (username, fName, email, number, bid, hash, type, dateCreated) VALUES (:username, :fName, :email, :number, null, :hash, 'patient', :dateCreated)";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':dateCreated', $dateCreated);
                $stmt->bindParam(':fName', $fullname);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':number', $number);
                $stmt->bindParam(':hash', $hash);

                if ($stmt->execute()) {
            
                    $uid = $db->lastInsertId();
            
                    $sql = "INSERT INTO addresses (uid, building, road, block) VALUES (:uid, :building, :road, :block)";
                    $stmt = $db->prepare($sql);
            
                    $stmt->bindParam(':uid', $uid);
                    $stmt->bindParam(':building', $building);
                    $stmt->bindParam(':road', $road);
                    $stmt->bindParam(':block', $block);
            
                    $stmt->execute();
                    $db->commit();
            
                    $_SESSION["userId"] = $db->lastInsertId();
                    $_SESSION["username"] = $username;
                    $_SESSION["role"] = 'patient';
    
                    if(isset($_POST['rememberMe']) && $_POST['rememberMe'] == 'rememberMe'){
                        $data = $_SESSION["userId"].'#'.$_SESSION["username"]."#".$_SESSION["role"];
                        $data = base64_encode($data);
                        setcookie("session", $data,time() + 604800, '/', '', true, true);
                    }
                    
                    if(!isset($_COOKIE["redirect"])){
                        $_SESSION['success'] = "Sign Up Successful!";
                        header("Location: /pharmacy-management-system/mainpage.php");
                    }else{
                        header("Location: ".$_COOKIE["redirect"]);
                        setcookie ("redirect", $redirectUrl, time() - 3600,'/');
                    }
                } else {

                    $db->rollback();            
                    $_SESSION['error'] = "Sign Up Error!";
                    header("Location: /pharmacy-management-system/auth/signup.php");
                    exit();
                }
            }
        }
    }

}
