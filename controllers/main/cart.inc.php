<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_SESSION['userId'])){

        try {
            $cart = json_decode($_POST['cart'], true);
            if(empty($cart)){
                //handle
            }else{
                $paymentMethod = $_POST['paymentMethod'];
                $paymentMethodValid = preg_match('/^(creditCard|cash)$/', $paymentMethod);
                if($paymentMethodValid){

                    if($paymentMethod == "creditCard"){
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
                        $stripe = new \Stripe\StripeClient($_ENV['secret_key']);
                        $session = $stripe->checkout->sessions->create([
                            'payment_method_types' => ['card'],
                            'line_items' => $lineItems,
                            'mode' => 'payment',
                            'success_url' => 'https://example.com/success',
                            'cancel_url' => 'https://example.com/cancel',
                            'metadata' => [
                                'user_id' => $_SESSION['userId'],
                                'totalBill' => $totalBill,
                                'productsQty' => json_encode($productsQty)
                            ],
                        ]);
                        
                        header("Location: " . $session->url);

                    }else{
                        //handle
                    }

                }else{
                    // handle
                }
          
                  
            }
        
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
    }
}
?> 