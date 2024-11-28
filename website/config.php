<?php
require 'vendor/autoload.php';
require 'connect.php';
use PHPMailer\PHPMailer\PHPMailer;
$client = new Google_Client;

$sql = "SELECT * FROM tblids_google";
$stmt = $mysqli->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$client->setClientId($row["client_id"]);
$client->setClientSecret($row["client_secret"]);
$client->SetRedirectUri("http://localhost/tiago/2024-2025-Groep-2/website/successLogin.php");

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();

?>