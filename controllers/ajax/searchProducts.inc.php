<?php
session_start();
require_once('../../vendor/autoload.php');
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();
require('../../functions/connection.inc.php');
require('../../functions/functions.inc.php');
require("../../partials/regex.inc.php");

if (isset($_GET['searchQuery'])) {
  $searchQuery = $_GET['searchQuery'];


  $query = "SELECT products.* FROM products WHERE products.name LIKE :searchQuery";
  $stmt = $db->prepare($query);
  $stmt->execute(array(':searchQuery' => "%$searchQuery%"));
  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $response = [
    'products' => $products
  ];
  header('Content-Type: application/json');
  echo json_encode($response);
  exit();
}
