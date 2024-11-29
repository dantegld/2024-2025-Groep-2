<?php
include 'functies/functies.php';
include 'connect.php';
session_start(); // Start de sessie

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION["klant_id"])) {
    header("Location: login.php");
    exit();
}

// Als het formulier wordt ingediend
if (isset($_POST['recensie_indienen'])) {
    $text = $_POST['text'];
    $rating = $_POST['rating'];
    $klant_id = $_SESSION['klant_id'];
    $artikel_id = intval($_POST['artikel_id']);

    // Voeg de recensie toe via de functie
    recensieToevoegen($klant_id, $rating, $text, $artikel_id);

    // Doorsturen naar een ander scherm (bijvoorbeeld recensies bekijken)
    header("Location: recenciesBekijken.php?artikel_id=$artikel_id");
    exit();
}

// HTML-formulier weergeven (alleen als de gebruiker is ingelogd)
if (isset($_SESSION["klant"])) {
    echo "<form action='recenciesToevoegen.php' method='post'>";
    echo "<textarea name='text' required placeholder='Write your review...'></textarea><br>";
    echo "<label for='rating'>Rating:</label>";
    echo "<select name='rating' id='rating' required>";
    echo "<option value='5'>5 - Excellent</option>";
    echo "<option value='4'>4 - Good</option>";
    echo "<option value='3'>3 - OK</option>";
    echo "<option value='2'>2 - Poor</option>";
    echo "<option value='1'>1 - Terrible</option>";
    echo "</select><br>";
    echo "<input type='hidden' name='artikel_id' value='" . htmlspecialchars($_GET['artikel_id']) . "'>";
    echo "<input type='submit' name='recensie_indienen' value='Submit Review'>";
    echo "</form>";
}
?>
