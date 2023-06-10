<?php
require('../../partials/regex.inc.php');
require('../../functions/mailer.inc.php');
require('../../functions/functions.inc.php');
if (isset($_SESSION['userId'])) {
    if ($_SESSION['role'] == 'pharmacist') {

        $query = 
        "SELECT products.*
        FROM products
        LEFT JOIN products_in_branch ON products.pid = products_in_branch.pid
        WHERE products_in_branch.pid IS NULL
        AND products.isDeleted = 0;";
        $stmt = $db->query($query);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (isset($_POST['submit'])) {
            $qty = $_POST['qty'];
            $pid = $_POST['pid'];


            if ($_POST['qty'] != "" && $_POST['pid'] != "") {

                $qtyValid = preg_match($idReg, $qty);
                $pidValid = preg_match($idReg, $pid);


                if (!$qtyValid) {
                    $_SESSION['error'] = "Invalid Quantity";
                    header("Location: /pharmacy-management-system/pharmacist/manageStocks/addStock.php?qty=".$qty."&pid=".$pid);
                } elseif (!$pidValid) {
                    $_SESSION['error'] = "Invalid Product";
                    header("Location: /pharmacy-management-system/pharmacist/manageStocks/addStock.php?qty=".$qty."&pid=".$pid);
                } else {
                    $sql = "INSERT INTO products_in_branch (pid, bid, qty) VALUES (:pid, :bid, :qty)";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':pid', $pid);
                    $stmt->bindParam(':bid', $_SESSION['bid']);
                    $stmt->bindParam(':qty', $qty);
                        
                    if ($stmt->execute()) {
                        $_SESSION['success'] = "Product created successfully";
                        header("Location: /pharmacy-management-system/pharmacist/manageStocks/stocksList.php");
                        exit();
                    } else {
                        $_SESSION['error'] = "Failed to insert user into the database";
                        header("Location: /pharmacy-management-system/pharmacist/manageStocks/stocksList.php");
                        exit();
                    }
                }
            } else {
                $_SESSION['error'] = "Please make sure all data is inputed";
                header("Location: /pharmacy-management-system/pharmacist/manageStocks/addStock.php?qty=".$qty."&pid=".$pid);
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
