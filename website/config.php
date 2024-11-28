<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
$client = new Google_Client;

$client->setClientId("267762598007-rt1je04qcbodlri0lqp9ihfkd83b5j64.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->SetRedirectUri("http://localhost/tiago/2024-2025-Groep-2/website/successLogin.php");

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();

?>