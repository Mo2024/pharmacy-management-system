<?php
session_start();
require_once('../../../vendor/autoload.php');
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__.'/../../../');
$dotenv->load();
require('../../../functions/connection.inc.php');
require('../../../functions/functions.inc.php');

$cid = $_POST['cid'];

$stmt = $db->prepare("DELETE FROM category WHERE cid = ?");
$stmt->execute([$cid]);

if ($stmt->rowCount() > 0) {
  echo "true";
}
?>
