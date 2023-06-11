<?php
require('../../partials/regex.inc.php');
require('../../functions/mailer.inc.php');
require('../../functions/functions.inc.php');
if (isset($_SESSION['userId'])) {
    if ($_SESSION['role'] == 'pharmacist') {
        
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];


            if ($_POST['name'] != "") {

                $nameValid = preg_match('/^[A-Za-z\s]+$/', $name);


                if (!$nameValid) {
                    $_SESSION['error'] = "Invalid Name";
                    header("Location: /pharmacy-management-system/pharmacist/manageCategories/addCategory.php?name=".$name);
                }else {
                  
                    $sql = "INSERT INTO category (name) VALUES (:name)";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':name', $name);
        
                
                    if ($stmt->execute()) {
                
                        $_SESSION['success'] = "Category created successfully";
                        header("Location: /pharmacy-management-system/pharmacist/manageCategories/addCategory.php");
                        exit();
                    } else {
    
                        $_SESSION['error'] = "Failed to insert user into the database";
                        header("Location: /pharmacy-management-system/pharmacist/manageCategories/addCategory.php");
                        exit();
                    }
                }
            } else {
                $_SESSION['error'] = "Please make sure all data is inputed";
                header("Location: /pharmacy-management-system/pharmacist/manageCategories/addCategory.php?name=".$name);
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
