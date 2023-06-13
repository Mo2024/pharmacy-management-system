<!-- <?php $title = "webhook"; require('partials/boilerplate.inc.php')?> -->
<?php
require_once __DIR__ . '/vendor/autoload.php';
require('functions/mailer.inc.php');
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$servername = $_ENV['servername'];
$username = $_ENV['username'];
$password = $_ENV['password'];
$db = new PDO($servername, $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$stripe = new \Stripe\StripeClient($_ENV['secret_key']);

$endpoint_secret = $_ENV['endpoint'];

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
  $event = \Stripe\Webhook::constructEvent(
    $payload, $sig_header, $endpoint_secret
  );
} catch(\UnexpectedValueException $e) {
  // Invalid payload
  http_response_code(400);
  exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
  // Invalid signature
  http_response_code(400);
  exit();
}

// Handle the event
switch ($event->type) {
  case 'account.updated':
    $account = $event->data->object;
  case 'account.external_account.created':
    $externalAccount = $event->data->object;
  case 'account.external_account.deleted':
    $externalAccount = $event->data->object;
  case 'account.external_account.updated':
    $externalAccount = $event->data->object;
  case 'checkout.session.completed':
    $session = $event->data->object;
    $metadata = $session->metadata;
    $productsQty = json_decode($metadata['productsQty']);
    // Insert the order data into the "orders" table in your database
    // Adapt this code to use your specific database connection and query method
    $db->beginTransaction();

    $query = "INSERT INTO orders (oid, totalPrice, paymentMethod, orderDate, status, uid) VALUES (?, ?, 'Credit Card', ?, 'pending', ?)";
    $dateCreated = date("F d\, Y");
    $stmt = $db->prepare($query);
    $stmt->execute([$metadata['oid'], $metadata['totalBill'], $dateCreated, $metadata['user_id']]);
    
    $query = "INSERT INTO products_in_order (oid, pid, qty) VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);

    foreach($productsQty as $item){
      $stmt->execute([$metadata['oid'], $item->pid, $item->qty]);
      $patientQty = $item->qty;
      $sql = 'select pb.* from products_in_branch as pb where pid = ?';
      $statement = $db->prepare($sql);
      $statement->execute([$item->pid]);
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
    $statement->execute([$metadata['oid']]);
    $row = $statement->fetch();
    $recipientEmail = $row['email'];
    $subject = 'Order Successfull!';
    $body = 'Order No '.$row['oid'].' has been placed!';

    $message->setTo($recipientEmail);
    $message->setSubject($subject);
    $message->setBody($body);
    $mailer->send($message);
    break;
  default:
    echo 'Received unknown event type ' . $event->type;
}

http_response_code(200);
