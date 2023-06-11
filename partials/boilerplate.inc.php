<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- bootstrap 5.0.2 -->
  <link rel="stylesheet" href="/pharmacy-management-system/public/css/bootstrap.min.css">
  <link rel="stylesheet" href="/pharmacy-management-system/public/css/main.css">
  <script src="/pharmacy-management-system/public/js/bootstrap.min.js"></script>
  
  <title><?php echo $title;?></title>
</head>

<body class="min-vh-100 d-flex flex-column">
  <?php 
    session_start();
    if((isset($_SESSION['forgetuid']) && $_SERVER['REQUEST_URI'] != '/pharmacy-management-system/auth/forgetPassword.php')
    || (isset($_SESSION['display']) && $_SERVER['REQUEST_URI'] != '/pharmacy-management-system/auth/forgetPassword.php')){
      unset($_SESSION['display']);
      unset($_SESSION['forgetuid']);
    }
    require_once(realpath(__DIR__.'/../vendor/autoload.php'));
    use Dotenv\Dotenv;
    $dotenv = Dotenv::createImmutable(__DIR__.'/../');
    $dotenv->load();

    require(__DIR__ ."/../functions/connection.inc.php");

    $query = "SELECT category.* FROM category";
    $statement = $db->prepare($query);
    $statement->execute();
    $categoryRows = $statement->fetchAll(PDO::FETCH_ASSOC);

    $brandName = $_ENV['brandName'];
    //Extends cookie's duration if the user is constantly using it
    if(isset($_COOKIE['session'])){
      if(!isset($_SESSION["username"])){
        $dataCookie = $_COOKIE['session'];
        $data = base64_decode($dataCookie);
        $data = explode('#', $data);
        $_SESSION['userId'] = $data[0];
        $_SESSION['username'] = $data[1];
        $_SESSION['role'] = $data[2];
        setcookie("session", $dataCookie,time() + 604800, '/', '', true, true);
      }
    }
  ?>


  <?php require(__DIR__.'/../partials/navbar.inc.php'); ?>

  <main class="container mt-5">
  <?php require('notification.inc.php');?>
  