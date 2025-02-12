<?php
include 'connect.php';
session_start();
include 'functies/functies.php';
controleerKlant();

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
if(!isset($_GET["schoenmaat"])){
    $sql = "SELECT schoenmaat FROM tblklant WHERE klant_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $klant_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $schoenmaat = $row["schoenmaat"];

    if ($result->num_rows == 0 || empty($schoenmaat)) {
        $schoenmaat = 40;
    }

}else if (!empty($_GET["schoenmaat"])) {
    $schoenmaat = $_GET["schoenmaat"];
}else{
    $schoenmaat = 40;
}



    $sql = "INSERT INTO tblwinkelwagen (klant_id, artikel_id, aantal, variatie_id, schoenmaat) VALUES ($klant_id, $artikel_id, 1, $variatie_id, $schoenmaat)";
    print_r($sql);
    if ($mysqli->query($sql) === TRUE) {
        
        //add a count to how many times the product has been added to the cart
        $sql = "UPDATE tblartikels SET addedCart = addedCart + 1 WHERE artikel_id = $artikel_id";
        if ($mysqli->query($sql) === TRUE) {
            header("Location: winkelwagen.php");
        exit();
        } else {
            echo "Error updating record: " . $mysqli->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error; 
    }


?>
