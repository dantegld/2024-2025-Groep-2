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

// Login check
if (!isset($_SESSION["klant_id"])) {
    header("Location: login.php");
    exit();
}

// zien of artikel_id is geset	
if (!isset($_GET['artikel_id'])) {
    echo "No article specified.";
    exit();
}

$artikel_id = intval($_GET['artikel_id']);

// goed gekeurde recensies tonen
$sql = "SELECT r.*, k.klantnaam, a.artikelnaam 
        FROM tblrecensies r 
        JOIN tblklant k ON r.klant_id = k.klant_id 
        JOIN tblartikels a ON r.artikel_id = a.artikel_id 
        WHERE r.goedGekeurd = 1 AND a.artikel_id = ? 
        ORDER BY r.recensie_id";

$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    die("Error preparing statement: " . $mysqli->error);
}

$stmt->bind_param("i", $artikel_id);
$stmt->execute();
$resultaat = $stmt->get_result();

// Display reviews
if ($resultaat->num_rows > 0) {
    $row = $resultaat->fetch_assoc();
    echo "<h2>Reviews for " . htmlspecialchars($row["artikelnaam"]) . "</h2>";
    do {
        echo "<p>Customer: " . htmlspecialchars($row["klantnaam"]) . "</p>";
        echo "<p>Review: " . htmlspecialchars($row["text"]) . "</p>";
        echo "<p>Rating: " . htmlspecialchars($row["rating"]) . "/5</p>";
        echo "<hr>";
    } while ($row = $resultaat->fetch_assoc());
} else {
    echo "<h2>No reviews found for this article.</h2>";
}

echo "<a href='index.php'>Back to index</a>";

$stmt->close();
?>
