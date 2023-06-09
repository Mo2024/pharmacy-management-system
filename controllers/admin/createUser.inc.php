<?php
require('../functions/mailer.inc.php');
require('../functions/functions.inc.php');

if (isset($_SESSION['userId'])) {
    if ($_SESSION['role'] === 'admin') {

        if (isset($_POST['submit'])) {

            $username = $_POST['username'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $number = $_POST['number'];
            $building = $_POST['building'];
            $road = $_POST['road'];
            $block = $_POST['block'];
            $role = $_POST['role'];

            // Validate username
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                $_SESSION['error'] = "Invalid Username";
                header("Location: /pharmacy-management-system/admin/createUser.php?username=" . urlencode($username) . "&fullname=" . urlencode($fullname) . "&email=" . urlencode($email) . "&number=" . urlencode($number) . "&building=" . urlencode($building) . "&road=" . urlencode($road) . "&block=" . urlencode($block) . "&role=" . urlencode($role)."&branches=".$bid);
            }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Invalid email";
                header("Location: /pharmacy-management-system/admin/createUser.php?username=" . urlencode($username) . "&fullname=" . urlencode($fullname) . "&email=" . urlencode($email) . "&number=" . urlencode($number) . "&building=" . urlencode($building) . "&road=" . urlencode($road) . "&block=" . urlencode($block) . "&role=" . urlencode($role)."&branches=".$bid);
            }else if (!preg_match('/^\d+$/', $number)) {
                $_SESSION['error'] = "Invalid number";
                header("Location: /pharmacy-management-system/admin/createUser.php?username=" . urlencode($username) . "&fullname=" . urlencode($fullname) . "&email=" . urlencode($email) . "&number=" . urlencode($number) . "&building=" . urlencode($building) . "&road=" . urlencode($road) . "&block=" . urlencode($block) . "&role=" . urlencode($role)."&branches=".$bid);
            }else{
                $sql = "SELECT * FROM users WHERE username = :username";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
    
                if ($stmt->rowCount() > 0) {
                    $_SESSION['error'] = "Username already exists";
                    header("Location: /pharmacy-management-system/admin/createUser.php?error=username");
                    exit();
                }
    
                $sql = "SELECT * FROM users WHERE email = :email";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
    
                if ($stmt->rowCount() > 0) {
                    $_SESSION['error'] = "Email already exists";
                    header("Location: /pharmacy-management-system/admin/createUser.php?error=email");
                    exit();
                }
                
                $password = generateRandomPassword();
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $db->beginTransaction();

                if($role == "pharmacist"){
                    $sql = "INSERT INTO users (username, fName, email, number, bid, hash, type) VALUES (:username, :fName, :email, :number, :bid, :hash, :role)";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':bid', $_POST['branches']);

                }else{
                    $sql = "INSERT INTO users (username, fName, email, number, bid, hash, type) VALUES (:username, :fName, :email, :number, null, :hash, :role)";
                    $stmt = $db->prepare($sql);
                }
                
                $stmt->bindParam(':username', $username);
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
                    header("Location: /pharmacy-management-system/admin/createUser.php");
                    exit();
                } else {
                    
                    $db->rollback();            
                    $_SESSION['error'] = "Failed to insert user into the database";
                    header("Location: /pharmacy-management-system/admin/createUser.php?error=db");
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

// Function to
?>