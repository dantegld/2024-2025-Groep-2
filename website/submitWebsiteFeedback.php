<?php
session_start();
include 'functies/functies.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $klant_id = $_SESSION['klant_id'];
    $rating = $_POST['rating'];
    $text = $_POST['text'];

    addWebsiteReview($klant_id, $rating, $text);
    header("Location: index.php?review_submitted=true");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>