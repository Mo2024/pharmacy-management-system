<?php 
require('../../functions/functions.inc.php');
require("../../partials/regex.inc.php");
if(isset($_SESSION['userId'])){
    if($_SESSION['role'] == "pharmacist"){
        if(isset($_GET['supplierId'])){
            $sid = $_GET['supplierId'];
            $sidQuery = "SELECT * FROM suppliers WHERE sid = '$sid'";
            $result = $db->query($sidQuery);
            $row = $result->fetch();
        }else{
            $_SESSION['error'] = "Choose a valid Supplier";
            header("Location: /pharmacy-management-system/pharmacist/manageSuppliers/suppliersList.php");
        }

        if(isset($_POST['submit'])){
            $sid = $_POST['submit'];
            $name = $_POST['name'];
            $building = $_POST['building'];
            $road = $_POST['road'];
            $block = $_POST['block'];

            $nameValid = preg_match($nameReg, $name);
            $buildingValid = preg_match('/^[a-zA-Z0-9\s]+$/', $building);
            $roadValid = preg_match('/^[a-zA-Z0-9\s]+$/', $road);
            $blockValid = preg_match('/^[a-zA-Z0-9\s]+$/', $block); 

            if (!$nameValid) {
                $_SESSION['error'] = "Invalid name";
                header("Location: /pharmacy-management-system/pharmacist/manageSuppliers/editSupplier.php?supplierId=".$sid);
            } elseif (!$buildingValid) {
                $_SESSION['error'] = "Invalid building";
                header("Location: /pharmacy-management-system/pharmacist/manageSuppliers/editSupplier.php?supplierId=".$sid);
            } elseif (!$roadValid) {
                $_SESSION['error'] = "Invalid road";
                header("Location: /pharmacy-management-system/pharmacist/manageSuppliers/editSupplier.php?supplierId=".$sid);
            } elseif (!$blockValid) {
                $_SESSION['error'] = "Invalid block";
                header("Location: /pharmacy-management-system/pharmacist/manageSuppliers/editSupplier.php?supplierId=".$sid);
            }else{
                $insertQuery = "UPDATE suppliers SET name = :name, building = :building, road = :road, block = :block WHERE sid = :sid";
                $stmt = $db->prepare($insertQuery);
                $stmt->bindParam(':sid', $sid);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':road', $road);
                $stmt->bindParam(':building', $building);
                $stmt->bindParam(':block', $block);
                $stmt->execute();

                $_SESSION['success'] = "Supplier's Info Updated";
                header("Location: /pharmacy-management-system/pharmacist/manageSuppliers/SuppliersList.php");
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
