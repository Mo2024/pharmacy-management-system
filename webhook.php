<?php
require_once __DIR__ . '/vendor/autoload.php';
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
    $query = "INSERT INTO orders (totalPrice, paymentMethod, orderDate, status, uid) VALUES (?, 'Credit Card', ?, 'pending', ?)";
    $dateCreated = date("F d\, Y");
    $stmt = $db->prepare($query);
    $stmt->execute([$metadata['totalBill'], $dateCreated, $metadata['user_id']]);
    
    $query = "INSERT INTO products_in_order (oid, pid, qty) VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);
    $oid = $db->lastInsertId();

    foreach($productsQty as $item){
        $stmt->execute([$oid, $item->pid, $item->qty]);
    }
    $db->commit();

    break;
  default:
    echo 'Received unknown event type ' . $event->type;
}

http_response_code(200);

?>