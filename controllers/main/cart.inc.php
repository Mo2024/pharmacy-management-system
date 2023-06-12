<?php 
use Ramsey\Uuid\Uuid;
require('functions/mailer.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_SESSION['userId'])){

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
                            'cancel_url' => 'http://localhost/pharmacy-management-system/cancel.php',
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
                    $_SESSION['error'] = 'Must choose a valid payment method!';
                    header('Location: http://localhost/pharmacy-management-system/cart.php');                 
                }
          
                  
            }
        
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
    }
}
?> 