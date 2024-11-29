<?php
include 'functies/functies.php';
include 'connect.php';

// admin check
session_start();
controleerAdmin();

// Ongekeurde recensies bekijken
if (isset($_GET['admin_view'])) {
  $sql_reviews = "SELECT * FROM tblrecensies WHERE goedGekeurd = 0";
  $resultaat = mysqli_query($mysqli, $sql_reviews);

  echo "<h2>Pending Reviews</h2>";
  while ($recensie = mysqli_fetch_assoc($resultaat)) {
    echo "<p>" . $recensie["text"] . "</p>";
    echo "<p>Rating: " . $recensie["rating"] . "/5</p>";
    echo "<form action='recensieGoedkeuren.php' method='post'>";
    echo "<input type='hidden' name='recensie_id' value='" . $recensie["recensie_id"] . "'>";
    echo "<input type='submit' name='goedkeuren' value='Approve'>";
    echo "</form>";
  }
  $resultaat->close();
  $mysqli->close();
}

// Recensies goedkeuren
if (isset($_POST['goedkeuren'])) {
  $recensie_id = $_POST['recensie_id'];
  recensieGoedkeuren($recensie_id);
  header("Location: recensieGoedkeuren.php?admin_view=1");
  exit();
}
?>