<?php
include 'connect.php';
include 'functies/functies.php';
session_start();
if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$artikel_id = $_GET["id"];

if (!isset($_SESSION["klant_id"])) {
    header("Location: login.php");
    exit();
}

$klant_id = $_SESSION["klant_id"];
$sql1 = "SELECT schoenmaat FROM tblklant WHERE klant_id = $klant_id";
$result = $mysqli->query($sql1);
if ($result->num_rows == 0) {
    $sql = "INSERT INTO tblwinkelwagen (klant_id, artikel_id, aantal) VALUES ($klant_id, $artikel_id, 1)";
    if ($mysqli->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error; 
}
}else{
    $row = $result->fetch_assoc();
    $schoenmaat = $row["schoenmaat"];
    $sql = "INSERT INTO tblwinkelwagen (klant_id, artikel_id, schoenmaat, aantal) VALUES ($klant_id, $artikel_id, $schoenmaat, 1)";
    if ($mysqli->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error; 
    }
}

?>
