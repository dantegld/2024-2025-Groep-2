<?php
include 'connect.php';
session_start();
include 'functies/functies.php';
controleerKlant();
onderhoudsModus();
$klant_id = $_SESSION['klant_id'];
if (isset($_GET['adres_id'])) {
    $id = $_GET['adres_id'];
    $sql = "DELETE FROM tbladres WHERE adres_id = $id and klant_id = $klant_id";
    $mysqli->query($sql);
    $mysqli->close(); // Close the MySQL connection
    header('Location: profile');
} else {
    $mysqli->close(); // Close the MySQL connection
    header('Location: profile');
}


