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