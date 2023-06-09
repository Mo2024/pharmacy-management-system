<?php
session_start();
require_once('../../../vendor/autoload.php');
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__.'/../../../');
$dotenv->load();
require('../../../functions/connection.inc.php');
require('../../../functions/functions.inc.php');

$sid = $_POST['sid'];

$stmt = $db->prepare("DELETE FROM suppliers WHERE sid = ?");
$stmt->execute([$sid]);

if ($stmt->rowCount() > 0) {
  echo "true";
}
?>
