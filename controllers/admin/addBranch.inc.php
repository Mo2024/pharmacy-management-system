<?php
// Assuming you have started the session

if (isset($_SESSION['userId'])) {
    if ($_SESSION['role'] == 'admin') {

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $area = $_POST['area'];
            $building = $_POST['building'];
            $road = $_POST['road'];
            $block = $_POST['block'];
            if ($_POST['name'] != "" && $_POST['area'] != "" && $_POST['building'] != "" && $_POST['road'] != "" && $_POST['block'] != "") {

                $nameValid = preg_match('/^[a-zA-Z\s]+$/', $name);
                $areaValid = preg_match('/^[a-zA-Z\s]+$/', $area);
                $buildingValid = preg_match('/^[a-zA-Z0-9\s]+$/', $building);
                $roadValid = preg_match('/^[a-zA-Z0-9\s]+$/', $road);
                $blockValid = preg_match('/^[a-zA-Z0-9\s]+$/', $block);

                if (!$nameValid) {
                    $_SESSION['error'] = "Invalid name";
                    header("Location: /pharmacy-management-system/admin/addBranch.php?name=".$name."&area=".$area."&building=".$building."&road=".$road."&block=".$block);
                } else if (!$areaValid) {
                    $_SESSION['error'] = "Invalid area";
                    header("Location: /pharmacy-management-system/admin/addBranch.php?name=".$name."&area=".$area."&building=".$building."&road=".$road."&block=".$block);
                } else if (!$buildingValid) {
                    $_SESSION['error'] = "Invalid building";
                    header("Location: /pharmacy-management-system/admin/addBranch.php?name=".$name."&area=".$area."&building=".$building."&road=".$road."&block=".$block);
                } else if (!$roadValid) {
                    $_SESSION['error'] = "Invalid road";
                    header("Location: /pharmacy-management-system/admin/addBranch.php?name=".$name."&area=".$area."&building=".$building."&road=".$road."&block=".$block);
                } else if (!$blockValid) {
                    $_SESSION['error'] = "Invalid block";
                    header("Location: /pharmacy-management-system/admin/addBranch.php?name=".$name."&area=".$area."&building=".$building."&road=".$road."&block=".$block);
                } else {
                    $stmt = $db->prepare("INSERT INTO branches (name, area, building, road, block) VALUES (?, ?, ?, ?, ?)");

                    $stmt->execute([$name, $area, $building, $road, $block]);

                    $_SESSION['success'] = "Branch added successfully";
                    header("Location: /pharmacy-management-system/admin/addBranch.php");
                }
            } else {
                $_SESSION['error'] = "Please make sure all data is inputed";
                header("Location: /pharmacy-management-system/admin/addBranch.php?name=".$name."&area=".$area."&building=".$building."&road=".$road."&block=".$block);
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
