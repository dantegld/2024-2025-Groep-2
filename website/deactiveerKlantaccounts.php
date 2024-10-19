<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Klantaccounts</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
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
   <link rel="icon" href="images/icon/favicon.png">
   </head>
   <style>
   body {
       font-family: 'Poppins', sans-serif;
       background-color: #f5f5f5;
       margin: 0;
       padding: 0;
   }
   table {
       width: 70%; /* Maak de tabel breder naar 70% */
       border-collapse: collapse;
       background-color: #fff;
       box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
       margin: 0 auto; /* Centreer de tabel */
   }
   th, td {
       padding: 10px;
       text-align: center;
       border: 1px solid #ddd;
   }
   th {
       background-color: #007BFF;
       color: white;
       font-weight: normal;
   }
   td {
       color: #333;
   }
   tr:nth-child(even) {
       background-color: #f2f2f2;
   }
   input[type="submit"] {
       background-color: #ff4d4d;
       color: white;
       border: none;
       padding: 10px 15px;
       cursor: pointer;
       border-radius: 5px;
       font-size: 14px;
       transition: background-color 0.3s ease;
   }
   input:hover {
       background-color: #e60000;
   }
   .message {
       text-align: center;
       font-size: 18px;
       color: #333;
       margin-top: 20px;
   }
   .message.success {
       color: #28a745;
   }
   .message.error {
       color: #dc3545;
   }
   form {
       display: inline;
   }
   .container {
       text-align: center;
       padding: 20px;
   }
   .wachtwoord-cell {
    max-width: 250px;
    word-wrap: break-word;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
}

</style>


   </head>
   <body>
   <?php
include 'connect.php'; 
include 'functies/functies.php';
controleerAdmin();
include 'functies/adminSideMenu.php';
?>
<div class="adminpage">
    <?php
        if (isset($_POST['verwijderen'])) {
            if (!empty($_POST['klant_id'])) { // Only check for klant_id
                $klant_id = $_POST['klant_id'];
    
    
                // Verwijder query uitvoeren
                $deleteQuery = "DELETE FROM tblklant WHERE klant_id = '$klant_id'";
                $deleteResult = $mysqli->query($deleteQuery);
                
                if ($deleteResult) {
                    echo "<div class='message success'>De klant met ID $klant_id is succesvol verwijderd.</div>";
                } else {
                    echo "<div class='message error'>Er is een fout opgetreden bij het verwijderen van de klant.</div>";
                }
            } else {
                echo "<div class='message error'>Niet alle gegevens zijn verstrekt.</div>";
            }
        }
    $query = "SELECT * FROM tblklant WHERE type = 'klant'";
    $result = $mysqli->query($query);
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Klant ID</th><th>Klantnaam</th><th>Email</th><th>Wachtwoord</th><th>Telefoonnummer</th><th>Schoenmaat</th><th>Type</th><th>Actie</th></tr>";
        while ($row = $result->fetch_assoc()) {
            // Start the form here
            echo "<tr>";
            echo "<form method='POST' action=''>"; // Make sure action is set correctly

         
            echo "<td>" . $row['klant_id'] . "</td>";
            echo "<td>" . $row['klantnaam'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td class='wachtwoord-cell'>" . $row['wachtwoord'] . "</td>";
            echo "<td>" . $row['telefoonnummer'] . "</td>";
            echo "<td>" . $row['schoenmaat'] . "</td>";
            echo "<td>" . $row['type'] . "</td>";
            echo "<td>
                      <input type='hidden' name='klant_id' value='" . $row['klant_id'] . "' />
                      <input type='hidden' name='klantnaam' value='" . $row['klantnaam'] . "' /> <!-- Added hidden fields -->
                      <input type='hidden' name='email' value='" . $row['email'] . "' />
                      <input type='hidden' name='wachtwoord' value='" . $row['wachtwoord'] . "' />
                      <input type='hidden' name='telefoonnummer' value='" . $row['telefoonnummer'] . "' />
                      <input type='hidden' name='schoenmaat' value='" . $row['schoenmaat'] . "' />
                      <input type='hidden' name='type' value='" . $row['type'] . "' />

                      <input type='submit' name='verwijderen' value='Verwijderen' />
                  </td>";
            echo "</form>"; // End the form here
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Geen oude of niet-beschikbare producten gevonden.";
    }

    

    ?>
</div>
   </body>
</html>