<?php
require('../../partials/regex.inc.php');
require('../../functions/mailer.inc.php');
require('../../functions/functions.inc.php');
use Intervention\Image\ImageManager;

if (isset($_SESSION['userId'])) {
    if ($_SESSION['role'] == 'pharmacist') {

        $sql = "SELECT sid, name FROM suppliers";
        $stmt = $db->query($sql);
        $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM category";
        $stmt = $db->query($sql);
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $type = $_POST['type'];
            $sid = $_POST['suppliers'];
            $cid = $_POST['cid'];


            if ($_POST['name'] != "" && $_POST['price'] != "" && $_POST['type'] != "" && $_POST['suppliers'] != "" && $_POST['cid'] != "") {

                $nameValid = preg_match('/^[A-Za-z\s]+$/', $name);
                $priceValid = preg_match($priceReg, $price);
                $sidValid = preg_match($idReg, $sid);
                $cidValid = preg_match($idReg, $cid);
                $typeValid = preg_match('/^[A-Za-z\s]+$/', $type);


                if (!$nameValid) {
                    $_SESSION['error'] = "Invalid Name";
                    header("Location: /pharmacy-management-system/pharmacist/manageProducts/addProduct.php?name=".$name."&price=".$price."&type=".$type."&suppliers=".$sid."&cid=".$cid);
                } elseif (!$priceValid) {
                    $_SESSION['error'] = "Invalid Price";
                    header("Location: /pharmacy-management-system/pharmacist/manageProducts/addProduct.php?name=".$name."&price=".$price."&type=".$type."&suppliers=".$sid."&cid=".$cid);
                } elseif (!$typeValid) {
                    $_SESSION['error'] = "Invalid Type";
                    header("Location: /pharmacy-management-system/pharmacist/manageProducts/addProduct.php?name=".$name."&price=".$price."&type=".$type."&suppliers=".$sid."&cid=".$cid);
                }  elseif (!$sidValid) {
                    $_SESSION['error'] = "Invalid Supplier";
                    header("Location: /pharmacy-management-system/pharmacist/manageProducts/addProduct.php?name=".$name."&price=".$price."&type=".$type."&suppliers=".$sid."&cid=".$cid);
                }  elseif (!$cidValid) {
                    $_SESSION['error'] = "Invalid Category";
                    header("Location: /pharmacy-management-system/pharmacist/manageProducts/addProduct.php?name=".$name."&price=".$price."&type=".$type."&suppliers=".$sid."&cid=".$cid);
                } else {
                    $db->beginTransaction();           
                    $sql = "INSERT INTO products (name, type, price, sid, cid) VALUES (:name, :type, :price, :sid, :cid)";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':type', $type);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':sid', $sid);
                    $stmt->bindParam(':cid', $cid);
                        
                    if ($stmt->execute()) {

                        $newProductId =  $db->lastInsertId();
                        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                            $file = $_FILES['image'];
                        
                            // Check if the uploaded file is an image
                            $allowedExtensions = array('jpg', 'jpeg', 'png');
                            $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                        
                            if (in_array($fileExtension, $allowedExtensions)) {
                                // Convert the file to JPEG if it is PNG or JPEG
                                if ($fileExtension !== 'jpg') {
                                    $image = imagecreatefromstring(file_get_contents($file['tmp_name']));
                                    if ($image !== false) {
                                        $newFileName = $newProductId . '.jpg';
                                        $destinationPath = '../../public/products/' . $newFileName;
                                        imagejpeg($image, $destinationPath, 100);
                                        imagedestroy($image);
                                    } else {
                                        $db->rollback();
                                        $_SESSION['error'] = "Failed to convert image to JPEG";
                                        header("Location: /pharmacy-management-system/pharmacist/manageProducts/addProduct.php?name=".$name."&price=".$price."&type=".$type."&suppliers=".$sid."&cid=".$cid);
                                        exit();
                                    }
                                } else {
                                    $newFileName = $newProductId . '.' . $fileExtension;
                                    $destinationPath = '../../public/products/' . basename($newFileName);
                                }
                        
                                // Move the uploaded file to the destination folder
                                if (!move_uploaded_file($file['tmp_name'], $destinationPath)) {
                                    $db->rollback();
                                    $_SESSION['error'] = "Failed to upload";
                                    header("Location: /pharmacy-management-system/pharmacist/manageProducts/addProduct.php?name=".$name."&price=".$price."&type=".$type."&suppliers=".$sid."&cid=".$cid);
                                    exit();
                                }
                            } else {
                                $db->rollback();
                                $_SESSION['error'] = "File must be an image";
                                header("Location: /pharmacy-management-system/pharmacist/manageProducts/addProduct.php?name=".$name."&price=".$price."&type=".$type."&suppliers=".$sid."&cid=".$cid);
                                exit();
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
                header("Location: /pharmacy-management-system/pharmacist/manageProducts/addProduct.php?name=".$name."&price=".$price."&type=".$type."&suppliers=".$sid."&cid=".$cid);
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
