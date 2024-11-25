<?php
include 'functies/functies.php';
include 'connect.php';

//admin check
session_start();
if (!isset($_SESSION['type']) || $_SESSION['type'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Recensies bekijken
if (isset($_GET['artikel_id'])) {
  $artikel_id = intval($_GET['artikel_id']);
  $sql = "SELECT * FROM tblrecensies WHERE artikel_id = $artikel_id AND goedGekeurd = 1";
  $resultaat = mysqli_query($mysqli, $sql);

  echo "<h2>Reviews</h2>";
  while ($recensie = mysqli_fetch_assoc($resultaat)) {
    echo "<p>" . $recensie["text"] . "</p>";
    echo "<p>Rating: " . $recensie["rating"] . "/5</p>";
  }
}

?>