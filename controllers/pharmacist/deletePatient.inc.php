<?php
session_start();
require_once('../../vendor/autoload.php');
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();
require('../../functions/connection.inc.php');
require('../../functions/functions.inc.php');

$pid = $_POST['pid'];

$stmt = $db->prepare("SELECT type FROM users WHERE uid = ?");
$stmt->execute([$pid]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result && $result['type'] === "patient") {

    $stmt = $db->prepare("UPDATE users SET isDeleted = 1 WHERE uid = ?");
    $stmt->execute([$pid]);
    echo "true";
}
?>
