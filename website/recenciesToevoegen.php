<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Myshoes</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- fonts -->
      <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
      <!-- font awesome -->
      <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <!--  -->
      <!-- owl stylesheets -->
      <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Poppins:400,700&display=swap&subset=latin-ext" rel="stylesheet">
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesoeet" href="css/owl.theme.default.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
   <link rel="icon" href="images/icon/favicon.png">
   </head>
   <body>

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
