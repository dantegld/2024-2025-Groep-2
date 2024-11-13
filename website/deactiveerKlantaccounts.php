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
      <title>Customers</title>
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
   h1{
        text-align: center;
        margin-top: 50px;
   }
   table {
       width: 70%; /* Maak de tabel breder naar 70% */
       border-collapse: collapse;
       background-color: #fff;
       box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
       margin: 0 auto; /* Centreer de tabel */
       margin-top: 50px;
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
   input[type="submit"].delete {
       background-color: #ff4d4d;
       color: white;
       border: none;
       padding: 10px 15px;
       cursor: pointer;
       border-radius: 5px;
       font-size: 14px;
       transition: background-color 0.3s ease;
   }
    input[type="submit"].edit {
         background-color: #007BFF;
         color: white;
         border: none;
         padding: 10px 15px;
         cursor: pointer;
         border-radius: 5px;
         font-size: 14px;
         transition: background-color 0.3s ease;
    }
   input{
    border: none;
    text-align: center;
    background-color: transparent;
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
session_start();
include 'functies/functies.php';
controleerAdmin();
include 'functies/adminSideMenu.php';
?>
<div class="adminpage">
<h1>Customers</h1>
    <?php
        if (isset($_POST['verwijderen'])) {
            if (!empty($_POST['klant_id'])) { // Only check for klant_id
                $klant_id = $_POST['klant_id'];
    
    
                // Verwijder query uitvoeren
                $deleteQuery = "DELETE FROM tblklant WHERE klant_id = '$klant_id'";
                $deleteResult = $mysqli->query($deleteQuery);
                
                if ($deleteResult) {
                    echo "<div class='message success'>The customer with ID $klant_id has been successfully deleted.</div>";
                } else {
                    echo "<div class='message error'>An error occurred while deleting the customer.</div>";
                }
            } else {
                echo "<div class='message error'>Not all data has been provided</div>";
            }
        }

        if (isset($_POST['aanpassen'])) {
            if (isset($_POST['klant_id'], $_POST['klantnaam'], $_POST['email'], $_POST['telefoonnummer'], $_POST['schoenmaat'], $_POST['type'])) {
                $klant_id = $_POST['klant_id'];
                $klantnaam = $_POST['klantnaam'];
                $email = $_POST['email'];
                $telefoonnummer = $_POST['telefoonnummer'];
                $schoenmaat = $_POST['schoenmaat'];
                $type = $_POST['type'];
                $updateQuery = "UPDATE tblklant SET klantnaam = '$klantnaam', email = '$email', telefoonnummer = '$telefoonnummer', schoenmaat = '$schoenmaat', type = '$type' WHERE klant_id = '$klant_id'";
                $updateResult = $mysqli->query($updateQuery);
                if ($updateResult) {
                    echo "<div class='message success'>The customer with ID $klant_id has been updated successfully.</div>";
                } else {
                    echo "<div class='message error'>An error occurred while updating the customer.</div>";
                }
            } else {
                echo "<div class='message error'>Not all data has been provided.</div>";
            }
        }

        $myKlantID = $_SESSION['klant_id'];
    $query = "SELECT * FROM tblklant,tbltypes WHERE NOT klant_id = '$myKlantID' and tblklant.type_id = tbltypes.type_id";
    $result = $mysqli->query($query);
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Customer ID</th><th>Customer name</th><th>E-mail</th><th>Phone number</th><th>Shoe size</th><th>Type</th><th>Action</th><th>Delete</th></tr>";
        while ($row = $result->fetch_assoc()) {
            // Start the form here
            $typesql = "SELECT * FROM tbltypes";
            $typeresult = $mysqli->query($typesql);
            echo "<tr>";
            echo "<form method='POST' action='deactiveerKlantaccounts.php'>"; // Make sure action is set correctly

         
            echo "<td>" . $row['klant_id'] . "</td>";
            echo "<td><input type='text' name='klantnaam' value='" . $row['klantnaam'] . "' /></td>";
            echo "<td><input type='email' name='email' value='" . $row['email'] . "' /></td>";
            echo "<td><input type='text' name='telefoonnummer' value='" . $row['telefoonnummer'] . "' /></td>";
            echo "<td><input type='number' name='schoenmaat' value='" . $row['schoenmaat'] . "' /></td>";
            
            echo "<td><select class='selectTable' name='type'>";
            while ($typerow = $typeresult->fetch_assoc()) {
                echo "<option value='" . $typerow['type_id'] . "'";
                if ($typerow['type_id'] == $row['type_id']) {
                    echo " selected";
                }
                echo ">" . $typerow['type'] . "</option>";
            }
            echo "<td>
                          <input type='hidden' name='klant_id' value='" . $row['klant_id'] . "' />
                          <input class='edit' type='submit' name='aanpassen' value='Adjust' />
                      </td>";
            echo "<td>
                          <input type='hidden' name='klant_id' value='" . $row['klant_id'] . "' />
                          <input class='delete' type='submit' name='verwijderen' value='Delete' />
                      </td>";
            echo "</form>"; // End the form here
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No Customers found";
    }
    echo "<br>";
    

    ?>
</div>
   </body>
</html>