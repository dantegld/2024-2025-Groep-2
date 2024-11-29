<?php
include 'connect.php';
include 'functies/functies.php';
require 'vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST["submit"])){
    $naam = $_POST['naam'];
    $prijs = $_POST['prijs'];

    // Voeg het artikel toe aan de database
    $sql = "INSERT INTO tblartikels (artikelnaam, prijs) VALUES (?, ?)"; 
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $naam, $prijs);
    $stmt->execute();
    $artikel_id = $stmt->insert_id; // Haal het ID van het nieuw toegevoegde artikel op
    $stmt->close();

    // Haal alle klanten op met type_id = 2
    $sql = "SELECT * FROM tblklant WHERE type_id = 2";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    header("Location: aanpassen");
    $mysqli->close();
}
?>