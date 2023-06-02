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

  if($searchQuery == 'all' && isset($_GET['isSearchBtn'])){
    $query = "SELECT quiz.*, users.username FROM quiz INNER JOIN users ON quiz.uid = users.uid";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }else{
    $query = "SELECT quiz.*, users.username FROM quiz INNER JOIN users ON quiz.uid = users.uid WHERE quiz.title LIKE :searchQuery";
    $stmt = $db->prepare($query);
    $stmt->execute(array(':searchQuery' => "%$searchQuery%"));
    $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  $response = [
    'quizzes' => $quizzes
  ];
  header('Content-Type: application/json');
  echo json_encode($response);
  exit();
}
