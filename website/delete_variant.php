<?php
    include 'connect.php';    
    session_start();
    include 'functies/functies.php';
    controleerAdmin();

    $artikel_id = $_GET['artikel_id'];
    $variatie_id = $_GET['variatie_id'];
    $sql="DELETE FROM tblvariatie WHERE variatie_id = $variatie_id and artikel_id = $artikel_id";
    $result = $mysqli->query($sql);
    $sql="DELETE FROM tblstock WHERE variatie_id = $variatie_id and artikel_id = $artikel_id";
    $result = $mysqli->query($sql);
    $mysqli->close(); // Close the MySQL connection
    header("Location: variaties?artikel_id=$artikel_id");
