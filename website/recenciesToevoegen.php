<?php
include 'functies/functies.php';
include 'connect.php';

//login check
if (!isset($_SESSION["klant_id"])) {
  header("Location: login.php");
  exit();
}

if (isset($_POST['recensie_indienen'])) {
  $text = $_POST['text'];
  $rating = $_POST['rating'];
  $klant_id = $_POST['klant_id'];
  $artikel_id = $_POST['artikel_id'];

  recensieToevoegen($klant_id, $artikel_id, $rating, $text);

  header("Location: recenciesBekijken.php?artikel_id=$artikel_id");
  exit();
}

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
  echo "<input type='hidden' name='klant_id' value='" . $_SESSION["klant_id"] . "'>";
  echo "<input type='hidden' name='artikel_id' value='" . $_GET['artikel_id'] . "'>";
  echo "<input type='submit' name='recensie_indienen' value='Submit Review'>";
  echo "</form>";
}
?>
