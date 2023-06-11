<?php 
require('../../functions/functions.inc.php');
require("../../partials/regex.inc.php");
if(isset($_SESSION['userId'])){
    if($_SESSION['role'] == "pharmacist"){
        if(isset($_GET['productId'])){
            $pid = $_GET['productId'];
            $pidQuery = "SELECT * FROM products WHERE pid = '$pid'";
            $result = $db->query($pidQuery);
            $row = $result->fetch();

            $sql = "SELECT sid, name FROM suppliers";
            $stmt = $db->query($sql);
            $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $sql = "SELECT * FROM category";
            $stmt = $db->query($sql);
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $_SESSION['error'] = "Choose a valid Product";
            header("Location: /pharmacy-management-system/pharmacist/manageProducts/productsList.php");
        }

        if(isset($_POST['submit'])){
            $pid = $_POST['submit'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $type = $_POST['type'];
            $sid = $_POST['suppliers'];
            $cid = $_POST['cid'];


            $nameValid = preg_match('/^[A-Za-z\s]+$/', $name);
            $priceValid = preg_match($priceReg, $price);
            $sidValid = preg_match($idReg, $sid);
            $typeValid = preg_match('/^[A-Za-z\s]+$/', $type);
            $cidValid = preg_match($idReg, $cid);

 
            if (!$nameValid) {
                $_SESSION['error'] = "Invalid Name";
                header("Location: /pharmacy-management-system/pharmacist/manageProducts/editProduct.php?productId=".$pid);
            } elseif (!$priceValid) {
                $_SESSION['error'] = "Invalid Price";
                header("Location: /pharmacy-management-system/pharmacist/manageProducts/editProduct.php?productId=".$pid);
            } elseif (!$typeValid) {
                $_SESSION['error'] = "Invalid Type";
                header("Location: /pharmacy-management-system/pharmacist/manageProducts/editProduct.php?productId=".$pid);
            }  elseif (!$sidValid) {
                $_SESSION['error'] = "Invalid Type";
                header("Location: /pharmacy-management-system/pharmacist/manageProducts/editProduct.php?productId=".$pid);
            }elseif (!$cidValid) {
                $_SESSION['error'] = "Invalid Category";
                header("Location: /pharmacy-management-system/pharmacist/manageProducts/editProduct.php?productId=".$pid);
            }else{
                $db->beginTransaction();           
                $insertQuery = "UPDATE products SET name = :name, price = :price, type = :type, sid = :sid, cid = :cid WHERE pid = :pid";
                $stmt = $db->prepare($insertQuery);
                $stmt->bindParam(':pid', $pid);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':type', $type);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':sid', $sid);
                $stmt->bindParam(':cid', $cid);

                $filepath = '../../public/products/' . $pid;
                $filepathRollBack = '../../public/products/_deleted';
                if ($stmt->execute()) {

                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $file = $_FILES['image'];

                        if (file_exists($filepath . ".jpg")) {
                            rename($filepath . ".jpg", $filepathRollBack . ".jpg");
                        } else if (file_exists($filepath . ".png")) {
                            rename($filepath . ".png", $filepathRollBack . ".png");
                        } else if (file_exists($filepath . ".jpeg")) {
                            rename($filepath . ".jpeg", $filepathRollBack . ".jpeg");
                        }
                    
                        // Check if the uploaded file is an image
                        $allowedExtensions = array('jpg', 'jpeg', 'png');
                        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    
                        if (in_array($fileExtension, $allowedExtensions)) {
                            // Rename the file
                            $newFileName = $pid . '.' . $fileExtension;
                    
                            // Set the destination path to the "products" folder
                            $destinationPath = '../../public/products/' . basename($newFileName);
                    
                            // Move the uploaded file to the destination folder
                            if (!move_uploaded_file($file['tmp_name'], $destinationPath)) {
                                $db->rollback();
                                if (file_exists($filepathRollBack . ".jpg")) {
                                    rename($filepathRollBack . ".jpg", $filepath . ".jpg");
                                } else if (file_exists($filepathRollBack . ".png")) {
                                    rename($filepathRollBack . ".png", $filepath . ".png");
                                } else if (file_exists($filepathRollBack . ".jpeg")) {
                                    rename($filepathRollBack . ".jpeg", $filepath . ".jpeg");
                                }            
                                $_SESSION['error'] = "Failed to upload";
                                header("Location: /pharmacy-management-system/pharmacist/manageProducts/addProduct.php?name=" . $name . "&price=" . $price . "&type=" . $type . "&suppliers=" . $sid);
                            }
                        } else {
                            $db->rollback();
                            if (file_exists($filepathRollBack . ".jpg")) {
                                rename($filepathRollBack . ".jpg", $filepath . ".jpg");
                            } else if (file_exists($filepathRollBack . ".png")) {
                                rename($filepathRollBack . ".png", $filepath . ".png");
                            } else if (file_exists($filepathRollBack . ".jpeg")) {
                                rename($filepathRollBack . ".jpeg", $filepath . ".jpeg");
                            }            
                            $_SESSION['error'] = "File must be an image";
                            header("Location: /pharmacy-management-system/pharmacist/manageProducts/addProduct.php?name=" . $name . "&price=" . $price . "&type=" . $type . "&suppliers=" . $sid);
                        }
                    }    
                    $db->commit();
                    if (file_exists($filepathRollBack . ".jpg")) {
                        unlink($filepathRollBack . ".jpg");
                    } else if (file_exists($filepathRollBack . ".png")) {
                        unlink($filepathRollBack . ".png");
                    } else if (file_exists($filepathRollBack . ".jpeg")) {
                        unlink($filepathRollBack . ".jpeg");
                    }
                    $_SESSION['success'] = "Product created successfully";
                    header("Location: /pharmacy-management-system/pharmacist/manageProducts/productsList.php");
                    exit();
                } else {
                    $db->rollback();
                    if (file_exists($filepathRollBack . ".jpg")) {
                        rename($filepathRollBack . ".jpg", $filepath . ".jpg");
                    } else if (file_exists($filepathRollBack . ".png")) {
                        rename($filepathRollBack . ".png", $filepath . ".png");
                    } else if (file_exists($filepathRollBack . ".jpeg")) {
                        rename($filepathRollBack . ".jpeg", $filepath . ".jpeg");
                    }            
                    $_SESSION['error'] = "Failed to insert user into the database";
                    header("Location: /pharmacy-management-system/pharmacist/manageProducts/productsList.php");
                    exit();
                }

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

?>