<?php
require('../../partials/regex.inc.php');
require('../../functions/mailer.inc.php');
require('../../functions/functions.inc.php');
if (isset($_SESSION['userId'])) {
    if ($_SESSION['role'] == 'pharmacist') {

        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $fName = $_POST['fName'];
            $number = $_POST['number'];
            $block = $_POST['block'];
            $road = $_POST['road'];
            $building = $_POST['building'];
            $dateCreated = date("F d\, Y");

            if ($_POST['username'] != "" && $_POST['email'] != "" && $_POST['fName'] != "" && $_POST['number'] != ""  && $_POST['building'] != "" && $_POST['road'] != "" && $_POST['block'] != "") {

                $usernameValid = preg_match($usernameReg, $username);
                $emailValid = preg_match($emailReg, $email);
                $fNameValid = preg_match($nameReg, $fName);
                $numberValid = preg_match($idReg, $number);

                $buildingValid = preg_match('/^[a-zA-Z0-9\s]+$/', $building);
                $roadValid = preg_match('/^[a-zA-Z0-9\s]+$/', $road);
                $blockValid = preg_match('/^[a-zA-Z0-9\s]+$/', $block);

                if (!$usernameValid) {
                    $_SESSION['error'] = "Invalid username";
                    header("Location: /pharmacy-management-system/pharmacist/managePatients/addPatient.php?username=".$username."&email=".$email."&fName=".$fName."&number=".$number."&block=".$block."&road=".$road."&building=".$building);
                } elseif (!$emailValid) {
                    $_SESSION['error'] = "Invalid email";
                    header("Location: /pharmacy-management-system/pharmacist/managePatients/addPatient.php?username=".$username."&email=".$email."&fName=".$fName."&number=".$number."&block=".$block."&road=".$road."&building=".$building);
                } elseif (!$fNameValid) {
                    $_SESSION['error'] = "Invalid Full Name";
                    header("Location: /pharmacy-management-system/pharmacist/managePatients/addPatient.php?username=".$username."&email=".$email."&fName=".$fName."&number=".$number."&block=".$block."&road=".$road."&building=".$building);
                } elseif (!$numberValid) {
                    $_SESSION['error'] = "Invalid number";
                    header("Location: /pharmacy-management-system/pharmacist/managePatients/addPatient.php?username=".$username."&email=".$email."&fName=".$fName."&number=".$number."&block=".$block."&road=".$road."&building=".$building);
                } else if (!$buildingValid) {
                    $_SESSION['error'] = "Invalid building";
                    header("Location: /pharmacy-management-system/pharmacist/managePatients/addPatient.php?username=".$username."&email=".$email."&fName=".$fName."&number=".$number."&block=".$block."&road=".$road."&building=".$building);
                } else if (!$roadValid) {
                    $_SESSION['error'] = "Invalid road";
                    header("Location: /pharmacy-management-system/pharmacist/managePatients/addPatient.php?username=".$username."&email=".$email."&fName=".$fName."&number=".$number."&block=".$block."&road=".$road."&building=".$building);
                } else if (!$blockValid) {
                    $_SESSION['error'] = "Invalid block";
                    header("Location: /pharmacy-management-system/pharmacist/managePatients/addPatient.php?username=".$username."&email=".$email."&fName=".$fName."&number=".$number."&block=".$block."&road=".$road."&building=".$building);
                }else {
                    $sql = "SELECT * FROM users WHERE username = :username";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':username', $username);
                    $stmt->execute();
        
                    if ($stmt->rowCount() > 0) {
                        $_SESSION['error'] = "Username already exists";
                    header("Location: /pharmacy-management-system/pharmacist/managePatients/addPatient.php?username=".$username."&email=".$email."&fName=".$fName."&number=".$number."&block=".$block."&road=".$road."&building=".$building);
                        exit();
                    }
        
                    $sql = "SELECT * FROM users WHERE email = :email";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();
        
                    if ($stmt->rowCount() > 0) {
                        $_SESSION['error'] = "Email already exists";
                    header("Location: /pharmacy-management-system/pharmacist/managePatients/addPatient.php?username=".$username."&email=".$email."&fName=".$fName."&number=".$number."&block=".$block."&road=".$road."&building=".$building);
                        exit();
                    }
                    
                    $password = generateRandomPassword();
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $db->beginTransaction();
                    $sql = "INSERT INTO users (username, fName, email, number, bid, hash, type, dateCreated) VALUES (:username, :fName, :email, :number, null, :hash, 'patient', :dateCreated)";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':dateCreated', $dateCreated);
                    $stmt->bindParam(':fName', $fName);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':number', $number);
                    $stmt->bindParam(':hash', $hashedPassword);
        
                
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
                
                        $_SESSION['success'] = "Patient created successfully";
                        header("Location: /pharmacy-management-system/pharmacist/managePatients/managePatients.php");
                        exit();
                    } else {
    
                        $db->rollback();            
                        $_SESSION['error'] = "Failed to insert user into the database";
                        header("Location: /pharmacy-management-system/pharmacist/managePatients/managePatients.php");
                        exit();
                    }
                }
            } else {
                $_SESSION['error'] = "Please make sure all data is inputed";
                    header("Location: /pharmacy-management-system/pharmacist/managePatients/addPatient.php?username=".$username."&email=".$email."&fName=".$fName."&number=".$number."&block=".$block."&road=".$road."&building=".$building);
            }
        }
    } else {
        $_SESSION['error'] = "Unauthorized user";
        header("Location: /pharmacy-management-system/mainpage.php");
    }
} else {
    $_SESSION['error'] = "Please make login";
    header("Location: /pharmacy-management-system/auth/signin.php");
}
?>
