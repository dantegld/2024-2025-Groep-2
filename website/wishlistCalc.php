<?php
include 'connect.php';
include 'functies/functies.php';
session_start();
if (!isset($_GET["id"])) {
    header("Location: index");
    exit();
}

$artikel_id = $_GET["id"];

if (!isset($_SESSION["klant_id"])) {
    header("Location: login");
    exit();
}
$klant_id = $_SESSION["klant_id"];

$sql1 = "SELECT * FROM tblwishlist WHERE klant_id = $klant_id AND artikel_id = $artikel_id";
$result1 = $mysqli->query($sql1);
if ($result1->num_rows > 0) {
    $sql2 = "DELETE FROM tblwishlist WHERE klant_id = $klant_id AND artikel_id = $artikel_id";
    if ($mysqli->query($sql2) === TRUE) {
        header("Location: index");
        exit();
    }
} else {
    $sql = "INSERT INTO tblwishlist (klant_id, artikel_id,variatie_id) VALUES ($klant_id, $artikel_id, '1')";
    if ($mysqli->query($sql) === TRUE) {
        header("Location: index");
        exit();
    }
}


?>
