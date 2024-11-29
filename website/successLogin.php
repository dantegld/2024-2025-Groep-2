<?php
session_start();
require 'vendor/autoload.php';
require 'connect.php';
require 'config.php';

$token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
$client->setAccessToken($token["access_token"]);

$oauth = new Google\Service\Oauth2($client);

$userinfo = $oauth->userinfo->get();

$email = $userinfo->email;
$givenName = $userinfo->givenName;
$familyName = $userinfo->familyName ?? '';

$sql = "SELECT * FROM tblklant WHERE email = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['klant_id'] = $user['klant_id'];
    $_SESSION['klantnaam'] = $user['voornaam'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['type_id'] = $user['type_id'];

    $mysqli->close();
    header("Location: index.php");
    exit();
} else {
    $userType = 2;

    $stmt = $mysqli->prepare("INSERT INTO tblklant (klantnaam, email, type_id) VALUES (?, ?, ?)");
    print($givenName . $familyName . $email .  $userType);
    $stmt->bind_param("ssi", $givenName, $email, $userType);
    $stmt->execute();

    $_SESSION['klant_id'] = $mysqli->insert_id;
    $_SESSION['klantnaam'] = $givenName;
    $_SESSION['email'] = $email;
    $_SESSION['type_id'] = $userType;

    $mysqli->close();
    header("Location: index.php");
    exit();
}
