<?php
include("connect.php");
include 'functies/functies.php';
session_start();
controleerKlant();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM tblwishlist WHERE wishlist_id = " . $id . "";
    $mysqli->query($sql);
    $mysqli->close();
    header('Location: wishlist');
} else {
    echo '<h4>Er is iets fout gegaan</h4>';
    echo '<a href="wishlist">Go back to wishlist</a>';
}