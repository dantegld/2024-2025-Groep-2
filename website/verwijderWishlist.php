<?php
include("connect.php");
include 'functies/functies.php';
controleerKlant();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM tblwishlist WHERE wishlist_id = " . $id . "";
    $mysqli->query($sql);
    header('Location: wishlist.php');
} else {
    echo '<h4>Er is iets fout gegaan</h4>';
    echo '<a href="wishlist.php">Go back to wishlist</a>';
}