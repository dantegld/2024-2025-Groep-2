<?php
include 'connect.php';
include 'functies/functies.php';
session_start();
if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$artikel_id = $_GET["id"];
$_SESSION["artikel_id"] = $artikel_id;

if (!isset($_SESSION["klant_id"])) {
    header("Location: login.php");
    exit();
}

$klant_id = $_SESSION["klant_id"];

$sql = "INSERT INTO tblwinkelwagen (klant_id, artikel_id, aantal) VALUES ($klant_id, $artikel_id, 1)";

if ($mysqli->query($sql) === TRUE) {
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}

?>
