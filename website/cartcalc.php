<?php
include 'connect.php';
include 'functies/functies.php';
session_start();

if(!(isset($_GET["id"]))){
    header("Location: index.php");
}

$_SESSION["artikel_id"]=$_GET["id"];
$artikel_id=$_SESSION["artikel_id"];
$klant_id=$_SESSION["klant_id"];
$sql =  "INSERT INTO tblwinkelwagen (klant_id, artikel_id, aantal) VALUES ($klant_id, $artikel_id, 1)";
$result = $mysqli->query($sql);
if($result){
    header("Location: index.php");
}