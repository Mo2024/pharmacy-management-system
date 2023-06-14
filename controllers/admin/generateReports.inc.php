<?php

if (isset($_SESSION['userId'])) {
    if ($_SESSION['role'] !== 'admin') {
        $_SESSION['error'] = "Unauthorized user";
        header("Location: /pharmacy-management-system/mainpage.php");
    }
} else {
    $_SESSION['error'] = "Please make login";
    header("Location: /pharmacy-management-system/auth/signin.php");
}
