<?php 

// Functies van de website

// Functie om de onderhoudsmodus te controleren
function onderhoudsModus() {
   include 'connect.php';
   session_start();

   $sql = "SELECT functiewaarde FROM tbladmin where functienaam = 'onderhoudmodus'";
   $result = $mysqli->query($sql);
   $row = $result->fetch_assoc();
   
   if ($row["functiewaarde"] == 1 && $_SESSION['admin'] == FALSE) {
      header("Location: onderhoudsPagina.php");
   }
}

// Functie om de gebruiker te controleren
function controleerKlant() {
   session_start();

   if($_SESSION['klant'] == FALSE) {
      header("Location: logout.php");
   }
}
function controleerAdmin() {
   session_start();

   if($_SESSION['klant'] && $_SESSION['admin'] == FALSE) {
      header("Location: index.php");
   }else if ($_SESSION['klant'] == FALSE){
      header("Location: logout.php");
   }
}
function controleerEigenaar() {
   session_start();

   if($_SESSION['eigenaar'] == FALSE && $_SESSION['klant'] && $_SESSION['admin'] == FALSE) {
      header("Location: index.php");
   }else if ($_SESSION['klant'] == FALSE){
      header("Location: logout.php");
   }else if ($_SESSION['admin'] == FALSE){
      header("Location: admin.php");
   }
}