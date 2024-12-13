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
session_start();
controleerAdmin();

if (isset($_GET['approve'])) {
  $recensie_id = intval($_GET['approve']);
  recensieGoedkeuren($recensie_id);
  header("Location: recensieGoedkeuren.php");
  exit();
}

if (isset($_GET['delete'])) {
  $recensie_id = intval($_GET['delete']);
  recensieVerwijderen($recensie_id);
  header("Location: recensieGoedkeuren.php");
  exit();
}

$sql = "SELECT r.*, k.klantnaam, r.text, r.artikel_id 
        FROM tblrecensies r 
        JOIN tblklant k ON r.klant_id = k.klant_id 
        WHERE r.goedGekeurd = 0 
        ORDER BY r.recensie_id";
$resultaat = mysqli_query($mysqli, $sql);

echo "<h2>Pending Reviews</h2>";
while ($recensie = mysqli_fetch_assoc($resultaat)) {
  echo "<p>Article ID: " . htmlspecialchars($recensie["artikel_id"]) . "</p>";
  echo "<p>Customer: " . htmlspecialchars($recensie["klantnaam"]) . "</p>";
  echo "<p>Review: " . htmlspecialchars($recensie["text"]) . "</p>";
  echo "<p>Rating: " . htmlspecialchars($recensie["rating"]) . "/5</p>";
  echo "<a href='recensieGoedkeuren.php?approve=" . $recensie["recensie_id"] . "'>Approve</a> | ";
  echo "<a href='recensieGoedkeuren.php?delete=" . $recensie["recensie_id"] . "'>Delete</a>";
  echo "<hr>";
}

echo "<a href='index.php'>Back to index</a>";
?>