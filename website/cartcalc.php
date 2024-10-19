<?php
include 'connect.php';
include 'functies/functies.php';
session_start();
if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}
$klant_id = $_SESSION["klant_id"];

$artikel_id = $_GET["id"];
if (!isset($_GET["variatie_id"])) {
    $variatie_id = 1;
}else{
$variatie_id = $_GET["variatie_id"];
}

if (!isset($_SESSION["klant_id"])) {
    header("Location: login.php");
    exit();
}
if (!empty($_GET["schoenmaat"])) {
    $schoenmaat = $_GET["schoenmaat"];
}else{
    $sql = "SELECT schoenmaat FROM tblklant WHERE klant_id = $klant_id";
    print_r($sql);
    $result = $mysqli->query($sql);
    if ($result->num_rows == 0) {
        $schoenmaat = 40;
    }else{
        $row = $result->fetch_assoc();
        $schoenmaat = $row["schoenmaat"];
    }
}


$sql1 = "SELECT schoenmaat FROM tblklant WHERE klant_id = $klant_id";
print_r($sql1);
$result = $mysqli->query($sql1);
if ($result->num_rows == 0) {
    $sql = "INSERT INTO tblwinkelwagen (klant_id, artikel_id, aantal, variatie_id, schoenmaat) VALUES ($klant_id, $artikel_id, 1, $variatie_id, $schoenmaat)";
    print_r($sql);
    if ($mysqli->query($sql) === TRUE) {
        header("Location: winkelwagen.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error; 
}
}else{
    $row = $result->fetch_assoc();
    $sql = "INSERT INTO tblwinkelwagen (klant_id, artikel_id, aantal, variatie_id, schoenmaat) VALUES ($klant_id, $artikel_id, 1, $variatie_id, $schoenmaat)";
    print_r($sql);
    if ($mysqli->query($sql) === TRUE) {
        header("Location: winkelwagen.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error; 
    }
}

?>
