<?php
include 'connect.php';
include 'functies/functies.php';
session_start();
if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$artikel_id = $_GET["id"];

if (!isset($_SESSION["klant_id"])) {
    header("Location: login.php");
    exit();
}
$klant_id = $_SESSION["klant_id"];

$sql1 = "SELECT * FROM tblwishlist WHERE klant_id = $klant_id AND artikel_id = $artikel_id";
$result = $mysqli->query($sql1);
if ($result->num_rows > 0) {
    $sql2 = "DELETE FROM tblwishlist WHERE klant_id = $klant_id AND artikel_id = $artikel_id";
    if ($mysqli->query($sql2) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
    $sql = "INSERT INTO tblwishlist (klant_id, artikel_id) VALUES ($klant_id, $artikel_id)";
    if ($mysqli->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    }
    }
}
?>
