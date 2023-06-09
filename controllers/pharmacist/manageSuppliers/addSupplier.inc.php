<?php
require('../../partials/regex.inc.php');
require('../../functions/mailer.inc.php');
require('../../functions/functions.inc.php');
if (isset($_SESSION['userId'])) {
    if ($_SESSION['role'] == 'pharmacist') {

        $sql = "SELECT bid, name FROM branches";
        $stmt = $db->query($sql);
        $branches = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $area = $_POST['area'];
            $block = $_POST['block'];
            $road = $_POST['road'];
            $building = $_POST['building'];
            $branches = $_POST['branches'];
            $dateAdded = date("F d\, Y");

            if ($_POST['name'] != "" && $_POST['area'] != "" && $_POST['branches'] != ""  && $_POST['building'] != "" && $_POST['road'] != "" && $_POST['block'] != "") {

                $nameValid = preg_match($nameReg, $name);
                $branchValid = preg_match($idReg, $branches);
                $areaValid = preg_match('/^[a-zA-Z0-9\s]+$/', $area);
                $buildingValid = preg_match('/^[a-zA-Z0-9\s]+$/', $building);
                $roadValid = preg_match('/^[a-zA-Z0-9\s]+$/', $road);
                $blockValid = preg_match('/^[a-zA-Z0-9\s]+$/', $block);

                if (!$nameValid) {
                    $_SESSION['error'] = "Invalid Name";
                    header("Location: /pharmacy-management-system/pharmacist/manageSuppliers/addSupplier.php?name=".$name."&area=".$area."&branches=".$branches."&block=".$block."&road=".$road."&building=".$building);
                } elseif (!$branchValid) {
                    $_SESSION['error'] = "Invalid branch";
                    header("Location: /pharmacy-management-system/pharmacist/manageSuppliers/addSupplier.php?name=".$name."&area=".$area."&branches=".$branches."&block=".$block."&road=".$road."&building=".$building);
                } elseif (!$areaValid) {
                    $_SESSION['error'] = "Invalid Areae";
                    header("Location: /pharmacy-management-system/pharmacist/manageSuppliers/addSupplier.php?name=".$name."&area=".$area."&branches=".$branches."&block=".$block."&road=".$road."&building=".$building);
                } else if (!$buildingValid) {
                    $_SESSION['error'] = "Invalid building";
                    header("Location: /pharmacy-management-system/pharmacist/manageSuppliers/addSupplier.php?name=".$name."&area=".$area."&branches=".$branches."&block=".$block."&road=".$road."&building=".$building);
                } else if (!$roadValid) {
                    $_SESSION['error'] = "Invalid road";
                    header("Location: /pharmacy-management-system/pharmacist/manageSuppliers/addSupplier.php?name=".$name."&area=".$area."&branches=".$branches."&block=".$block."&road=".$road."&building=".$building);
                } else if (!$blockValid) {
                    $_SESSION['error'] = "Invalid block";
                    header("Location: /pharmacy-management-system/pharmacist/manageSuppliers/addSupplier.php?name=".$name."&area=".$area."&branches=".$branches."&block=".$block."&road=".$road."&building=".$building);
                }else {
                  
                    $sql = "INSERT INTO suppliers (name, area, road, building, bid, block, dateAdded) VALUES (:name, :area, :road, :building, :bid, :block, :dateAdded)";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':dateAdded', $dateAdded);
                    $stmt->bindParam(':area', $area);
                    $stmt->bindParam(':road', $road);
                    $stmt->bindParam(':building', $building);
                    $stmt->bindParam(':bid', $branches);
                    $stmt->bindParam(':block', $block);
        
                
                    if ($stmt->execute()) {
                
                        $_SESSION['success'] = "Patient created successfully";
                        header("Location: /pharmacy-management-system/pharmacist/manageSuppliers/suppliersList.php");
                        exit();
                    } else {
    
                        $_SESSION['error'] = "Failed to insert user into the database";
                        header("Location: /pharmacy-management-system/pharmacist/manageSuppliers/suppliersList.php");
                        exit();
                    }
                }
            } else {
                $_SESSION['error'] = "Please make sure all data is inputed";
                header("Location: /pharmacy-management-system/pharmacist/manageSuppliers/addSupplier.php?name=".$name."&area=".$area."&branches=".$branches."&block=".$block."&road=".$road."&building=".$building);
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
