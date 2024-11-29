<?php
include 'connect.php';
include 'functies/functies.php';
session_start();
if (!isset($_GET["id"])) {
    //header("Location: index.php");
    exit();
}

$artikel_id = $_GET["id"];
if (!isset($_GET["variatie_id"])) {
    $variant_id = 1;
}else{
$variatie_id = $_GET["variatie_id"];
}

if (!isset($_SESSION["klant_id"])) {
    header("Location: login");
    exit();
}
$klant_id = $_SESSION["klant_id"];

$sql1 = "SELECT * FROM tblwishlist WHERE klant_id = $klant_id AND artikel_id = $artikel_id AND variatie_id = $variatie_id";
$result1 = $mysqli->query($sql1);
if ($result1->num_rows > 0) {
    $sql2 = "DELETE FROM tblwishlist WHERE klant_id = $klant_id AND artikel_id = $artikel_id AND variatie_id = $variatie_id";
    if ($mysqli->query($sql2) === TRUE) {
        $mysqli->close();
        header("Location: productpagina?id=$artikel_id#product-details");
        exit();
    }
} else {
    $sql = "INSERT INTO tblwishlist (klant_id, artikel_id,variatie_id) VALUES ($klant_id, $artikel_id, '$variatie_id')";
    if ($mysqli->query($sql) === TRUE) {
        $mysqli->close();
        header("Location: productpagina?id=$artikel_id#product-details");
        exit();
    }
}

$mysqli->close();
?>
