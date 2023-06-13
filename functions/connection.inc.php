<?php
$servername = $_ENV['servername'];
$username = $_ENV['username'];
$password = $_ENV['password'];
$db = new PDO($servername, $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);