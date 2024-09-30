<?php 

// Functies van de website

// Functie om de onderhoudsmodus te controleren
function onderhoudsModus() {
   include 'connect.php';

   $sql = "SELECT functiewaarde FROM tbladmin where functienaam = 'onderhoudmodus'";
   $result = $mysqli->query($sql);
   $row = $result->fetch_assoc();
   echo $row["functiewaarde"];
   
   if ($row["functiewaarde"] == 1) {
      header("Location: onderhoudsPagina.php");
   } else {
      $_SESSION['onderhoudsMode'] = FALSE;
   }
}
