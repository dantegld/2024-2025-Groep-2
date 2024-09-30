<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myshoes</title>
        <!-- basic -->
        <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>OnderhoudsPagina</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- fonts -->
      <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
      <!-- font awesome -->
      <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <!--  -->
      <!-- owl stylesheets -->
      <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Poppins:400,700&display=swap&subset=latin-ext" rel="stylesheet">
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesoeet" href="css/owl.theme.default.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
   <link rel="icon" href="images/ico.png">
</head>
<body>
    
</body>



<?php
include 'connect.php';
session_start();
onderhoudsModus();

// Controleer of de klant is ingelogd
if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql="SELECT * FROM tblklant";
    $result = $mysqli->query($sql);
}

echo "<h1>Record Wijzigen</h1>";
include "connect.php";
if(isset($_POST['veranderen'])){
    
    $Nummer = $_POST['Nummer'];
    $Naam = $_POST['Naam'];
    $Voornaam = $_POST['Voornaam'];    
    $Straat = $_POST['Straat'];
    $Postcode = $_POST['Postcode'];
    $Plaats = $_POST['Plaats'];
    $Geboortedatum = $_POST['Geboortedatum'];
    $sql = "UPDATE klasgenoot SET Voornaam = '$Voornaam', Naam = '$Naam', Straat = '$Straat', Postcode = '$Postcode', Plaats = '$Plaats', Geboortedatum = '$Geboortedatum' WHERE Nummer = $Nummer";
    if($mysqli->query($sql)){
        echo "Record is gewijzigd";
    } else {
        echo "ERROR: " . $mysqli->error;
    }
    print "<br><a href='index.php'>Terug naar overzicht</a>";
}else 
{
    $sql = "SELECT * FROM klasgenoot WHERE Nummer = " . $_GET['teWijzigen'];
    $resultaat = $mysqli->query($sql);
    $row = $resultaat->fetch_assoc();
    echo '<table>
    <form action = "wijzigen.php" method="post">
        <tr>
            <td>Nummer</td>  <td> '. $row['Nummer'] . ' <input type="hidden" name="Nummer" value="' . $row['Nummer'] . '">

            <tr><td>VoorNaam        </td> <td>  <input type="text" name="Voornaam" value="' . $row['Voornaam'] . '">    </td></tr>
            <tr><td>Naam            </td> <td>  <input type="text" name="Naam" value="' . $row['Naam'] . '">            </td></tr>
            <tr><td>Straat          </td> <td>  <input type="text" name="Straat" value="' . $row['Straat'] . '">        </td></tr>
            <tr><td>Postcode        </td> <td>  <input type="text" name="Postcode" value="' . $row['Postcode'] . '">    </td></tr>
            <tr><td>Plaats          </td> <td>  <input type="text" name="Plaats" value="' . $row['Plaats'] . '">        </td></tr>
            <tr><td>Geboortedatum   </td> <td>  <input type="text" name="Geboortedatum" value="' . $row['Geboortedatum'] . '">  </td></tr>
            <tr><td colspan="2">               <input type="submit" name="veranderen" value="Record wijzigen"></td></tr>

            </form>
            </table>';
}
$mysqli->close();
?>



