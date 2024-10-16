<?php
if(!isset($_GET['id'])) {
    header("Location: winkelwagen.php");
    exit();
}
include("connect.php");
session_start();
include 'functies/functies.php';

$klant_id = $_SESSION["klant_id"];
$product_id = $_GET['id'];
$sql = "DELETE FROM tblwinkelwagen WHERE klant_id = $klant_id AND id = $product_id";
print_r($sql);
$mysqli->query($sql);
$result = $mysqli->query($sql);
header("Location: winkelwagen.php");
exit();


?>