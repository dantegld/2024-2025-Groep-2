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
