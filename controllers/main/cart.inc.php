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
                        foreach ($results as $product) {
                            $quantity = 1; 
                            foreach ($cart as $cartItem) {
                                if ($cartItem['pid'] === $product['pid']) {
                                $quantity = $cartItem['qty']; 
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
                            ];
                            
                            $lineItems[] = $lineItem;
                            $stripe = new \Stripe\StripeClient($_ENV['secret_key']);
                            $session = $stripe->checkout->sessions->create([
                                'payment_method_types' => ['card'],
                                'line_items' => $lineItems,
                                'mode' => 'payment',
                                'success_url' => 'https://example.com/success',
                                'cancel_url' => 'https://example.com/cancel',
                            ]);
                            header("Location: " . $session->url);
                        }      

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