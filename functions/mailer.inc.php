<?php
// create a new SwiftMailer instance
$transport = new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls');
$smtpEmail = $_ENV['smtpEmail'];
$url = $_ENV['url'];
$transport->setUsername($smtpEmail);
$transport->setPassword($_ENV['smtpPassword']);

$mailer = new Swift_Mailer($transport);

// create a new SwiftMailer message
$message = new Swift_Message();
$message->setFrom([$smtpEmail => 'ITCS333 G-2']);