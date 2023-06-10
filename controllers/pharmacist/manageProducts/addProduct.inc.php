<?php
require('../../partials/regex.inc.php');
require('../../functions/mailer.inc.php');
require('../../functions/functions.inc.php');
if (isset($_SESSION['userId'])) {
    if ($_SESSION['role'] == 'pharmacist') {

        $sql = "SELECT sid, name FROM suppliers";
        $stmt = $db->query($sql);
        $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $type = $_POST['type'];
            $sid = $_POST['suppliers'];


            if ($_POST['name'] != "" && $_POST['price'] != "" && $_POST['type'] != "" && $_POST['suppliers'] != "" ) {

                $nameValid = preg_match('/^[A-Za-z\s]+$/', $name);
                $priceValid = preg_match($priceReg, $price);
                $sidValid = preg_match($idReg, $sid);
                $typeValid = preg_match('/^[A-Za-z\s]+$/', $type);


                if (!$nameValid) {
                    $_SESSION['error'] = "Invalid Name";
                    header("Location: /pharmacy-management-system/pharmacist/manageProducts/addProduct.php?name=".$name."&price=".$price."&type=".$type."&suppliers=".$sid);
                } elseif (!$priceValid) {
                    $_SESSION['error'] = "Invalid Price";
                    header("Location: /pharmacy-management-system/pharmacist/manageProducts/addProduct.php?name=".$name."&price=".$price."&type=".$type."&suppliers=".$sid);
                } elseif (!$typeValid) {
                    $_SESSION['error'] = "Invalid Type";
                    header("Location: /pharmacy-management-system/pharmacist/manageProducts/addProduct.php?name=".$name."&price=".$price."&type=".$type."&suppliers=".$sid);
                }  elseif (!$sidValid) {
                    $_SESSION['error'] = "Invalid Type";
                    header("Location: /pharmacy-management-system/pharmacist/manageProducts/addProduct.php?name=".$name."&price=".$price."&type=".$type."&suppliers=".$sid);
                } else {
                    $db->beginTransaction();           
                    $sql = "INSERT INTO products (name, type, price, sid) VALUES (:name, :type, :price, :sid)";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':type', $type);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':sid', $sid);
                        
                    if ($stmt->execute()) {

                        $newProductId =  $db->lastInsertId();
                        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                            $file = $_FILES['image'];
                        
                            // Check if the uploaded file is an image
                            $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
                            $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                        
                            if (in_array($fileExtension, $allowedExtensions)) {
                                // Rename the file
                                $newFileName = $newProductId . '.' . $fileExtension;
                        
                                // Set the destination path to the "products" folder
                                $destinationPath = '../../public/products/' . basename($newFileName);
                        
                                // Move the uploaded file to the destination folder
                                if (!move_uploaded_file($file['tmp_name'], $destinationPath)) {
                                    $db->rollback();            
                                    $_SESSION['error'] = "Failed to upload";
                                    header("Location: /pharmacy-management-system/pharmacist/manageProducts/addProduct.php?name=" . $name . "&price=" . $price . "&type=" . $type . "&suppliers=" . $sid);
                                }
                            } else {
                                $db->rollback();            
                                $_SESSION['error'] = "File must be an image";
                                header("Location: /pharmacy-management-system/pharmacist/manageProducts/addProduct.php?name=" . $name . "&price=" . $price . "&type=" . $type . "&suppliers=" . $sid);
                            }
                        }    
                        $db->commit();
                        $_SESSION['success'] = "Product created successfully";
                        header("Location: /pharmacy-management-system/pharmacist/manageProducts/productsList.php");
                        exit();
                    } else {
                        $db->rollback();            
                        $_SESSION['error'] = "Failed to insert user into the database";
                        header("Location: /pharmacy-management-system/pharmacist/manageProducts/productsList.php");
                        exit();
                    }
                }
            } else {
                $_SESSION['error'] = "Please make sure all data is inputed";
                header("Location: /pharmacy-management-system/pharmacist/manageProducts/addProduct.php?name=".$name."&price=".$price."&type=".$type."&suppliers=".$sid);
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
