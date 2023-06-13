<?php
session_start();
require_once('../../vendor/autoload.php');
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();
require('../../functions/connection.inc.php');


try {

    $isRegistered = false; 
    if(isset( $_POST['email'])){
        $email = $_POST['email'];
        $emailQuery = "SELECT products.*, products_in_branch.* FROM products INNER JOIN products_in_branch.pid = products.pid";
        $emailStatement = $db->prepare($emailQuery);
        $emailStatement->bindParam(':email', $email);
        $emailStatement->execute();
    
        if ($emailStatement->rowCount() > 0) {
            $isRegistered = true;
        }

    }else if(isset($_POST['username'])){
        $username = $_POST['username'];
        $usernameQuery = "SELECT * FROM users WHERE BINARY username = :username";
        $usernameStatement = $db->prepare($usernameQuery);
        $usernameStatement->bindParam(':username', $username);
        $usernameStatement->execute();
    
        if ($usernameStatement->rowCount() > 0) {
            $isRegistered = true;
        }

    }



    $response = array("isRegistered" => $isRegistered);
    echo json_encode($response);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
