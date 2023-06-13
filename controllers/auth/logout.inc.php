<?php 
setcookie("session", "",time() - 604800 ,'/');
session_start();
session_destroy();
session_start();
$_SESSION['success'] = 'Sign out Successful';
header("Location: /pharmacy-management-system/mainpage.php");
exit();
