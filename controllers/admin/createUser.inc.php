<?php
require('../functions/mailer.inc.php');

// Assuming you have started the session

if (isset($_SESSION['userId'])) {
    if ($_SESSION['role'] === 'admin') {
        // User is logged in as admin

        // Check if the form was submitted
        if (isset($_POST['submit'])) {

            // Get the form data
            $username = $_POST['username'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $number = $_POST['number'];
            $building = $_POST['building'];
            $road = $_POST['road'];
            $block = $_POST['block'];
            $role = $_POST['role'];
            // $bid = $_POST['branches'];


            // Validate username
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                $_SESSION['error'] = "Invalid Username";
                header("Location: /pharmacy-management-system/admin/createUser.php?username=" . urlencode($username) . "&fullname=" . urlencode($fullname) . "&email=" . urlencode($email) . "&number=" . urlencode($number) . "&building=" . urlencode($building) . "&road=" . urlencode($road) . "&block=" . urlencode($block) . "&role=" . urlencode($role)."&branches=".$bid);
            }

            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Invalid email";
                header("Location: /pharmacy-management-system/admin/createUser.php?username=" . urlencode($username) . "&fullname=" . urlencode($fullname) . "&email=" . urlencode($email) . "&number=" . urlencode($number) . "&building=" . urlencode($building) . "&road=" . urlencode($road) . "&block=" . urlencode($block) . "&role=" . urlencode($role)."&branches=".$bid);
            }

            // Validate number (assuming it should contain only digits)
            if (!preg_match('/^\d+$/', $number)) {
                $_SESSION['error'] = "Invalid number";
                header("Location: /pharmacy-management-system/admin/createUser.php?username=" . urlencode($username) . "&fullname=" . urlencode($fullname) . "&email=" . urlencode($email) . "&number=" . urlencode($number) . "&building=" . urlencode($building) . "&road=" . urlencode($road) . "&block=" . urlencode($block) . "&role=" . urlencode($role)."&branches=".$bid);
            }


            // Check if the username already exists in the database
            $sql = "SELECT * FROM users WHERE username = :username";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // Username already exists, handle the error
                $_SESSION['error'] = "Username already exists";
                header("Location: /pharmacy-management-system/admin/createUser.php?error=username");
                exit();
            }

            // Check if the email already exists in the database
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // Email already exists, handle the error
                $_SESSION['error'] = "Email already exists";
                header("Location: /pharmacy-management-system/admin/createUser.php?error=email");
                exit();
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
            
            // Generate a random password
            $password = generateRandomPassword();

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $db->beginTransaction();

            $sql = "INSERT INTO users (username, fName, email, number, bid, hash, type) VALUES (:username, :fName, :email, :number, null, :hash, :role)";
            $stmt = $db->prepare($sql);
            
            // Bind the parameters
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':fName', $fullname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':number', $number);
            // $stmt->bindParam(':bid', $bid);
            $stmt->bindParam(':hash', $hashedPassword);
            $stmt->bindParam(':role', $role); // Updated from ':type' to ':role'            
        
            // Execute the query
            if ($stmt->execute()) {
                // Insert successful, commit the transaction
        
                // Get the last inserted user ID
                $uid = $db->lastInsertId();
        
                // Prepare the SQL query for address insertion
                $sql = "INSERT INTO addresses (uid, building, road, block) VALUES (:uid, :building, :road, :block)";
                $stmt = $db->prepare($sql);
        
                // Bind the parameters
                $stmt->bindParam(':uid', $uid);
                $stmt->bindParam(':building', $building);
                $stmt->bindParam(':road', $road);
                $stmt->bindParam(':block', $block);
        
                // Execute the query for address insertion
                $stmt->execute();
        
                // Commit the transaction
                $db->commit();
        
                // Send email to the user
                $subject = "Account Created";
                $messageBody = "Your account has been created.\n";
                $messageBody .= "Username: $username\n";
                $messageBody .= "Password: $password\n";
        
                // Set up the SwiftMailer message
        
                // Send the email
                $mailer->send($message);

                $recipientEmail = $email;
        
                $message->setTo($recipientEmail);
                $message->setSubject($subject);
                $message->setBody($messageBody);
                $mailer->send($message);
        
                // Redirect or display success message as desired
                $_SESSION['success'] = "User created successfully";
                header("Location: /pharmacy-management-system/admin/createUser.php");
                exit();
            } else {
                // Insert failed, rollback the transaction
                $db->rollback();
        
                $_SESSION['error'] = "Failed to insert user into the database";
                header("Location: /pharmacy-management-system/admin/createUser.php?error=db");
                exit();
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