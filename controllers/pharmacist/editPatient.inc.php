<?php 
require('../functions/functions.inc.php');
require("../partials/regex.inc.php");
if(isset($_SESSION['userId'])){
    if($_SESSION['role'] == "pharmacist"){
        if(isset($_GET['patientId'])){
            $pid = $_GET['patientId'];
            $pidQuery = "SELECT users.number, users.uid, users.type, addresses.road, addresses.building, addresses.block FROM users INNER JOIN addresses ON users.uid = addresses.uid WHERE users.uid = '$pid'";
            $result = $db->query($pidQuery);
            $row = $result->fetch();
            if($row['type'] != "patient"){
                $_SESSION['error'] = "You can't edit non patients users!";
                header("Location: /pharmacy-management-system/pharmacist/managePatients.php");
            }
        }else{
            $_SESSION['error'] = "Choose a valid Patient";
            header("Location: /pharmacy-management-system/pharmacist/managePatients.php");
        }

        if(isset($_POST['submit'])){
            $pid = $_POST['submit'];
            $number = $_POST['number'];
            $building = $_POST['building'];
            $road = $_POST['road'];
            $block = $_POST['block'];

            $postPidQuery = "SELECT users.number, users.uid, users.type, addresses.road, addresses.building, addresses.block FROM users INNER JOIN addresses ON users.uid = addresses.uid WHERE users.uid = '$pid'";
            $postResult = $db->query($postPidQuery);
            $postRow = $postResult->fetch();

            if($postRow['type'] != "patient"){
                $_SESSION['error'] = "You can't edit non patients users!";
                header("Location: /pharmacy-management-system/pharmacist/managePatients.php");
            }else{
                $buildingValid = preg_match('/^[a-zA-Z0-9\s]+$/', $building);
                $roadValid = preg_match('/^[a-zA-Z0-9\s]+$/', $road);
                $blockValid = preg_match('/^[a-zA-Z0-9\s]+$/', $block); 
    
                if (!preg_match('/^\d+$/', $number)) {
                    $_SESSION['error'] = "Invalid number";
                    header("Location: /pharmacy-management-system/pharmacist/editPatient.php?patientId=".$pid);
                } elseif (!$buildingValid) {
                    $_SESSION['error'] = "Invalid building";
                    header("Location: /pharmacy-management-system/pharmacist/editPatient.php?patientId=".$pid);
                } elseif (!$roadValid) {
                    $_SESSION['error'] = "Invalid road";
                    header("Location: /pharmacy-management-system/pharmacist/editPatient.php?patientId=".$pid);
                } elseif (!$blockValid) {
                    $_SESSION['error'] = "Invalid block";
                    header("Location: /pharmacy-management-system/pharmacist/editPatient.php?patientId=".$pid);
                }else{
                    $insertQuery = "UPDATE users SET number = :number WHERE uid = :uid";
                    $stmt = $db->prepare($insertQuery);
                    $stmt->bindParam(':uid', $pid);
                    $stmt->bindParam(':number', $number);
                    $stmt->execute();
    
                    $insertQuery = "UPDATE addresses SET building = :building, road = :road, block = :block WHERE uid = :uid";
                    $stmt = $db->prepare($insertQuery);
                    $stmt->bindParam(':uid', $pid);
                    $stmt->bindParam(':block', $block);
                    $stmt->bindParam(':building', $building);
                    $stmt->bindParam(':road', $road);
                    $stmt->execute();
    
                    $_SESSION['success'] = "Patient's Info Updated";
                    header("Location: /pharmacy-management-system/pharmacist/managePatients.php");
                }
            }
            
        }

    }else{
        $_SESSION['error'] = "Unauthorized user";
        header("Location: /pharmacy-management-system/mainpage.php");
    }
    
}else{
    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    setcookie("redirect", $url,0,'/');
    header("Location: /pharmacy-management-system/auth/signin.php");
}

?>