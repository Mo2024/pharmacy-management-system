<?php 
require('../functions/functions.inc.php');
require("../partials/regex.inc.php");
if(isset($_SESSION['userId'])){
    if($_SESSION['role'] == "pharmacist"){
        if(isset($_GET['patientId'])){
            $pid = $_GET['patientId'];
            $pidQuery = "SELECT users.*, addresses.road, addresses.building, addresses.block FROM users INNER JOIN addresses ON users.uid = addresses.uid WHERE users.uid = '$pid'";
            $result = $db->query($pidQuery);
            $row = $result->fetch();
        }else{
            $_SESSION['error'] = "Choose a valid Patient";
            header("Location: /pharmacy-management-system/pharmacist/managePatients.php");
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