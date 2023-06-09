<?php
require('../functions/mailer.inc.php');
require('../functions/functions.inc.php');
require('../partials/regex.inc.php');

if (isset($_SESSION['userId'])) {
    if ($_SESSION['role'] == 'admin') {

        $sql = "SELECT bid, name FROM branches";
        $stmt = $db->query($sql);
        $branches = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (isset($_POST['submit'])) {

            $username = $_POST['username'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $number = $_POST['number'];
            $building = $_POST['building'];
            $road = $_POST['road'];
            $block = $_POST['block'];
            $role = $_POST['role'];
            $dateCreated = date("F d\, Y");
            if(isset($_POST['branches'])){
                $bid = $_POST['branches'];
            }else{
                $bid = '';
            }

            $buildingValid = preg_match('/^[a-zA-Z0-9\s]+$/', $building);
            $roadValid = preg_match('/^[a-zA-Z0-9\s]+$/', $road);
            $blockValid = preg_match('/^[a-zA-Z0-9\s]+$/', $block); 
            $roleValid = preg_match($roleReg, $role); 

            if (!preg_match($usernameReg, $username)) {
                $_SESSION['error'] = "Invalid Username";
                header("Location: /pharmacy-management-system/admin/addUser.php?username=" . urlencode($username) . "&fullname=" . urlencode($fullname) . "&email=" . urlencode($email) . "&number=" . urlencode($number) . "&building=" . urlencode($building) . "&road=" . urlencode($road) . "&block=" . urlencode($block) . "&role=" . urlencode($role)."&branches=".$bid);
            }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Invalid email";
                header("Location: /pharmacy-management-system/admin/addUser.php?username=" . urlencode($username) . "&fullname=" . urlencode($fullname) . "&email=" . urlencode($email) . "&number=" . urlencode($number) . "&building=" . urlencode($building) . "&road=" . urlencode($road) . "&block=" . urlencode($block) . "&role=" . urlencode($role)."&branches=".$bid);
            }else if (!preg_match('/^\d+$/', $number)) {
                $_SESSION['error'] = "Invalid number";
                header("Location: /pharmacy-management-system/admin/addUser.php?username=" . urlencode($username) . "&fullname=" . urlencode($fullname) . "&email=" . urlencode($email) . "&number=" . urlencode($number) . "&building=" . urlencode($building) . "&road=" . urlencode($road) . "&block=" . urlencode($block) . "&role=" . urlencode($role)."&branches=".$bid);
            } elseif (!$buildingValid) {
                $_SESSION['error'] = "Invalid building";
                header("Location: /pharmacy-management-system/admin/addUser.php?username=" . urlencode($username) . "&fullname=" . urlencode($fullname) . "&email=" . urlencode($email) . "&number=" . urlencode($number) . "&building=" . urlencode($building) . "&road=" . urlencode($road) . "&block=" . urlencode($block) . "&role=" . urlencode($role)."&branches=".$bid);
            } elseif (!$roadValid) {
                $_SESSION['error'] = "Invalid road";
                header("Location: /pharmacy-management-system/admin/addUser.php?username=" . urlencode($username) . "&fullname=" . urlencode($fullname) . "&email=" . urlencode($email) . "&number=" . urlencode($number) . "&building=" . urlencode($building) . "&road=" . urlencode($road) . "&block=" . urlencode($block) . "&role=" . urlencode($role)."&branches=".$bid);
            } elseif (!$blockValid) {
                $_SESSION['error'] = "Invalid block";
                header("Location: /pharmacy-management-system/admin/addUser.php?username=" . urlencode($username) . "&fullname=" . urlencode($fullname) . "&email=" . urlencode($email) . "&number=" . urlencode($number) . "&building=" . urlencode($building) . "&road=" . urlencode($road) . "&block=" . urlencode($block) . "&role=" . urlencode($role)."&branches=".$bid);
            }elseif (!$roleValid) {
                $_SESSION['error'] = "Invalid role";
                header("Location: /pharmacy-management-system/admin/addUser.php?username=" . urlencode($username) . "&fullname=" . urlencode($fullname) . "&email=" . urlencode($email) . "&number=" . urlencode($number) . "&building=" . urlencode($building) . "&road=" . urlencode($road) . "&block=" . urlencode($block) . "&role=" . urlencode($role)."&branches=".$bid);
            }
            else{
                $sql = "SELECT * FROM users WHERE username = :username";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
    
                if ($stmt->rowCount() > 0) {
                    $_SESSION['error'] = "Username already exists";
                    header("Location: /pharmacy-management-system/admin/addUser.php");
                    exit();
                }
    
                $sql = "SELECT * FROM users WHERE email = :email";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
    
                if ($stmt->rowCount() > 0) {
                    $_SESSION['error'] = "Email already exists";
                    header("Location: /pharmacy-management-system/admin/addUser.php");
                    exit();
                }
                
                $password = generateRandomPassword();
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $db->beginTransaction();

                if($role == "pharmacist"){
                    if (!preg_match($idReg, $_POST['branches'])) {
                        $_SESSION['error'] = "Invalid branch";
                        header("Location: /pharmacy-management-system/admin/addUser.php?username=" . urlencode($username) . "&fullname=" . urlencode($fullname) . "&email=" . urlencode($email) . "&number=" . urlencode($number) . "&building=" . urlencode($building) . "&road=" . urlencode($road) . "&block=" . urlencode($block) . "&role=" . urlencode($role)."&branches=".$bid);
                    }
                    $sql = "INSERT INTO users (username, fName, email, number, bid, hash, type, dateCreated) VALUES (:username, :fName, :email, :number, :bid, :hash, :role, :dateCreated)";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':bid', $_POST['branches']);

                }else{
                    $sql = "INSERT INTO users (username, fName, email, number, bid, hash, type, dateCreated) VALUES (:username, :fName, :email, :number, null, :hash, :role, :dateCreated)";
                    $stmt = $db->prepare($sql);
                }
                
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':dateCreated', $dateCreated);
                $stmt->bindParam(':fName', $fullname);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':number', $number);
                $stmt->bindParam(':hash', $hashedPassword);
                $stmt->bindParam(':role', $role);          
    
            
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

                    $subject = "Account Created";
                    $messageBody = "Your account has been created.\n";
                    $messageBody .= "Username: $username\n";
                    $messageBody .= "Password: $password\n";
            

                    $mailer->send($message);
    
                    $recipientEmail = $email;
            
                    $message->setTo($recipientEmail);
                    $message->setSubject($subject);
                    $message->setBody($messageBody);
                    $mailer->send($message);
            
                    $_SESSION['success'] = "User created successfully";
                    header("Location: /pharmacy-management-system/admin/addUser.php");
                    exit();
                } else {

                    $db->rollback();            
                    $_SESSION['error'] = "Failed to insert user into the database";
                    header("Location: /pharmacy-management-system/admin/addUser.php");
                    exit();
                }

            }



        }
    } else {
        $_SESSION['error'] = "Unauthorized user";
        header("Location: /pharmacy-management-system/mainpage.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Please make login";
    header("Location: /pharmacy-management-system/auth/signin.php");
    exit();
}
?>