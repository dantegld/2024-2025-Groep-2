<?php
include 'connect.php';
include 'functies/functies.php';
if(isset($_POST["submit"])){
    $naam = $_POST['naam'];
    $prijs = $_POST['prijs'];
}

$sql = "INSERT INTO tblartikels (artikelnaam, prijs) VALUES (?, ?)"; 
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $naam, $prijs);
$stmt->execute();