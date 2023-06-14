<?php 
use Ramsey\Uuid\Uuid;
require('functions/mailer.inc.php');

if(isset($_SESSION['userId'])){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        try {
            $cart = json_decode($_POST['cart'], true);
            if(empty($cart)){
                $_SESSION['error'] = 'Cart is empty!';
                header('Location: http://localhost/pharmacy-management-system/mainpage.php');                   
            }else{
                $paymentMethod = $_POST['paymentMethod'];
                $paymentMethodValid = preg_match('/^(creditCard|cash)$/', $paymentMethod);
                if($paymentMethodValid){
                    $pids = array_column($cart, 'pid');
                    $placeholders = implode(',', array_fill(0, count($pids), '?'));
                    $query = "SELECT * FROM products WHERE pid IN ($placeholders)";
                    $statement = $db->prepare($query);
                    $statement->execute($pids);
                    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
                    
                    $isAvailable = true;
                    foreach ($results as $product) {
                        foreach ($cart as $cartItem) {
                            if ($cartItem['pid'] === $product['pid']) {
                            $quantity = $cartItem['qty'];

                                $sql = "SELECT SUM(qty) AS total_quantity FROM products_in_branch WHERE pid = :pid";
                                $stmt = $db->prepare($sql);
                                $stmt->bindParam(':pid', $product['pid']);
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
                                $totalDbQuantity = $result['total_quantity'];
                                if($quantity > $totalDbQuantity){
                                    if($totalDbQuantity > 0){
                                        $_SESSION['error'] = $product['name'].' is Out of Stock! Only '.$totalDbQuantity.' stocks is available';
                                    }else{
                                        $_SESSION['error'] = $product['name'].' is Out of Stock!';
                                    }
                                    $isAvailable = false;
                                    break 2;
                                }
                            }
                        }
                    }

                    if($isAvailable){
                        $lineItems = [];
                        $productsQty =[];
                        $totalBill = 0;
                        foreach ($results as $product) {
                            $quantity = 1; 
                            foreach ($cart as $cartItem) {
                                if ($cartItem['pid'] === $product['pid']) {
                                $quantity = $cartItem['qty'];
                                $totalBill = $totalBill + ($cartItem['qty'] * $product['price']);
                                break;
                                }
                            }
                            
                            $lineItem = [
                                'price_data' => [
                                'currency' => 'usd',
                                'unit_amount' => $product['price']*100, 
                                'product_data' => [
                                    'name' => $product['name'],
                                    'description' => $product['type'],
                                ],
                                ],
                                'quantity' => $quantity,
                                'metadata' => [
                                ],
                            ];
                            $productsQty[] = ['pid' => $product['pid'], 'qty' => $quantity];
                            $lineItems[] = $lineItem;
                        }      
    
                        $uuid = null;
                        $isUnique = false;
    
                        while (!$isUnique) {
                            $uuid = Uuid::uuid4()->toString();
                          
                            $query = "SELECT COUNT(*) FROM orders WHERE oid = :oid";
                            $stmt = $db->prepare($query);
                            $stmt->bindParam(':oid', $uuid);
                            $stmt->execute();
                            $count = $stmt->fetchColumn();
                          
                            if ($count === 0) {
                              $isUnique = true;
                            }
                        }
    
                        if($paymentMethod == "creditCard"){
                            $stripe = new \Stripe\StripeClient($_ENV['secret_key']);
                            $session = $stripe->checkout->sessions->create([
                                'payment_method_types' => ['card'],
                                'line_items' => $lineItems,
                                'mode' => 'payment',
                                'success_url' => 'http://localhost/pharmacy-management-system/success.php?orderId='.$uuid,
                                'cancel_url' => 'http://localhost/pharmacy-management-system/mainpage.php',
                                'metadata' => [
                                    'user_id' => $_SESSION['userId'],
                                    'totalBill' => $totalBill,
                                    'productsQty' => json_encode($productsQty),
                                    'oid' => $uuid
                                ],
                            ]);
                            
                            header("Location: " . $session->url);
    
                        }else{
                            $db->beginTransaction();
                            $query = "INSERT INTO orders (oid, totalPrice, paymentMethod, orderDate, status, uid) VALUES (?, ?, 'Cash', ?, 'pending', ?)";
                            $dateCreated = date("F d\, Y");
                            $stmt = $db->prepare($query);
                            $stmt->execute([$uuid, $totalBill, $dateCreated, $_SESSION['userId']]);
                            
                            $query = "INSERT INTO products_in_order (oid, pid, qty) VALUES (?, ?, ?)";
                            $stmt = $db->prepare($query);
    
                            foreach($productsQty as $item){
                                $stmt->execute([$uuid, $item['pid'], $item['qty']]);
                                $patientQty = $item['qty'];
                                $sql = 'select pb.* from products_in_branch as pb where pid = ?';
                                $statement = $db->prepare($sql);
                                $statement->execute([$item['pid']]);
                                $results = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach($results as $branch){
                                  if($patientQty > 0 ){
                                    if($branch['qty'] > 0){
                                      $patientQty = $patientQty - $branch['qty'];
                                      if($patientQty > 0){
                                        $updateQuery = 'update products_in_branch set qty = 0 where pid = ? and bid = ?';
                                        $statement = $db->prepare($updateQuery);
                                        $statement->execute([$branch['pid'], $branch['bid']]);              
                                      }else{
                                        $updateQuery = 'update products_in_branch set qty = ? where pid = ? and bid = ?';
                                        $statement = $db->prepare($updateQuery);
                                        $statement->execute([abs($patientQty), $branch['pid'], $branch['bid']]);
                                      }
                                    }
                                  }else{
                                    break;
                                  }
                                }
                              }
                            $db->commit();
    
                            $query = 
                            "SELECT orders.*, users.email
                            FROM orders
                            INNER JOIN users ON orders.uid = users.uid
                            WHERE orders.oid = ?";
    
                            $statement = $db->prepare($query);
                            $statement->execute([$uuid]);
                            $row = $statement->fetch();
                            $recipientEmail = $row['email'];
                            $subject = 'Order Successfull!';
                            $body = 'Order No '.$row['oid'].' has been placed!';
    
                            $message->setTo($recipientEmail);
                            $message->setSubject($subject);
                            $message->setBody($body);
                            $mailer->send($message); 
                            header('Location: http://localhost/pharmacy-management-system/success.php?orderId='.$uuid);                   
                        }

                    }else{
                        header('Location: http://localhost/pharmacy-management-system/cart.php');                   
                    }

                }else{
                    $_SESSION['error'] = 'Must choose a valid payment method!';
                    header('Location: http://localhost/pharmacy-management-system/cart.php');                 
                }
          
                  
            }
        
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
    }
}else{
    $_SESSION['error'] = "Please login";
    header("Location: /pharmacy-management-system/auth/signin.php");
}