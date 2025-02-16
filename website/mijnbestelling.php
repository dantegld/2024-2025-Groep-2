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
      <title>My orders</title>
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
      <style>
      /* General table styles */
      table {
          width: 100%;
          margin-top: 50px;
          border-collapse: collapse;
      }

      table th, table td {
          padding: 15px;
          text-align: center;
          border: 1px solid #ddd;
      }

      table th {
          background-color: #f8f9fa; 
          color: #333;
          font-weight: bold;
          text-transform: uppercase;
      }

      table td {
          vertical-align: middle;
          font-size: 1.1em;
          color: #555; 
      }

      table tr:nth-child(even) {
          background-color: #f2f2f2; 
      }

      /* Card container styles */
      .card-container {
          max-width: 1200px;
          margin: 0 auto;
          padding: 20px;
      }

      /* Card styles */
      .card {
          border: 1px solid #ddd;
          border-radius: 5px;
          margin-bottom: 20px;
      }

      .card-header {
          background-color: #f8f9fa;
          padding: 10px;
          font-size: 1.5em;
          font-weight: bold;
          color: #333;
      }

      .card-body {
          padding: 10px;
      }

      .card-footer {
          background-color: #f8f9fa;
          padding: 10px;
          font-size: 1.2em;
          font-weight: bold;
          color: #333;
          text-align: right;
      }
      </style>
   </head>
   <body>
   <div>
   <?php
include("connect.php");
session_start();
include 'functies/functies.php';
controleerKlant();
onderhoudsModus();
include 'functies/mySideNav.php';
echo '<br><span class="toggle_icon1" onclick="openNav()"><img width="44px" src="images/icon/Hamburger_icon.svg.png"></span>'; 

// Retourverwerking (met 'isset' en knopnaam via POST)
if (isset($_POST['retour'])) {
    // Verkrijg de POST-gegevens van de knop
    $verkoop_id = $_POST['verkoop_id'];
    $artikel_id = $_POST['artikel_id'];
    $klant_id = $_SESSION['klant_id'];  // Verondersteld dat de klant is ingelogd

    // Verkrijg de ontvangstdatum van de bestelling
    $query = "SELECT ontvangstdatum FROM tblaankoop WHERE verkoop_id = '$verkoop_id' AND klant_id = '$klant_id'";
    $result = mysqli_query($mysqli, $query);
    $row = mysqli_fetch_array($result);
    $ontvangstdatum = $row['ontvangstdatum'];

    // Bereken het aantal dagen sinds de ontvangst
    $huidige_datum = date('Y-m-d');
    $verschil = (strtotime($huidige_datum) - strtotime($ontvangstdatum)) / (60 * 60 * 24);

    // Controleer of het binnen de 3 dagen valt
    
        // Retour is geldig
        // Voeg het retourverzoek toe aan de tblGeretourneerdeProducten tabel
        
        $queryInsert = "INSERT INTO tblGeretourneerdeProducten (verkoop_id, artikel_id, klant_id) VALUES ('$verkoop_id', '$artikel_id', '$klant_id')";
        $resultInsert = mysqli_query($mysqli, $queryInsert);

        if ($resultInsert) {
            // Succesvolle invoer
            echo "<div class='alert alert-success'>Retour is succesvol aangevraagd!</div>";
        } else {
            // Fout bij invoer
            echo "<div class='alert alert-danger'>Er is een fout opgetreden bij het aanvragen van het retour.</div>";
        }
        // PHPMailer
    /*    $mail = new PHPMailer(true);

        try {
            // Host, wachtwoord, gebruikersnaam, etc.
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'myshoes@zoobagogo.com';
            $mail->Password = 'ShoesMy123!';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // zender en ontvanger
            $mail->setFrom('myshoes@zoobagogo.com', 'Myshoes');
            $mail->addAddress($email);

            // inhoud van de email
            $mail->isHTML(true);
            $mail->Subject = 'Return Request Confirmation';
            $mail->Body    = 'Dear customer,<br><br>We have received your return request. Our team will review the request and provide further instructions shortly.<br><br>Best regards,<br>Your Company';
            $mail->AltBody = 'Dear customer,\n\nWe have received your return request. Our team will review the request and provide further instructions shortly.\n\nBest regards,\nYour Company';

            // verzend de email
            $mail->send();
            echo 'Return request successfully received. A confirmation email has been sent to your email address.';
        } catch (Exception $e) {
            echo "Return request successfully received. However, we could not send a confirmation email. Mailer Error: {$mail->ErrorInfo}";
        }*/

}

// Bestellingen ophalen en weergeven
$query = "SELECT * FROM tblaankoop WHERE klant_id = '".$_SESSION['klant_id']."'";
$result = mysqli_query($mysqli, $query);

while ($row = mysqli_fetch_array($result)) {
    echo '<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Order #'.$row['verkoop_id'].'</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Return Package</th>
                            </tr>
                        </thead>
                        <tbody>';
                        
    $query2 = "SELECT * FROM tblartikels WHERE artikel_id = '".$row['artikel_id']."'";
    $result2 = mysqli_query($mysqli, $query2);
    $row2 = mysqli_fetch_array($result2); 
    $totaal = $row2['prijs'] * $row['aantal'];

    echo '<tr>
            <td>'.$row2['artikelnaam'].'</td>
            <td>'.$row['aantal'].'</td>
            <td>€'.$row2['prijs'].'</td>
            <td>€'. $totaal.'</td>
            <td>
                <form method="POST" action="">
                    <input type="hidden" name="verkoop_id" value="'.$row['verkoop_id'].'">
                    <input type="hidden" name="artikel_id" value="'.$row['artikel_id'].'">
                    <button type="submit" name="retour" class="btn btn-danger">Request Return</button>
                </form>
            </td>
        </tr>';
                        
    echo '</tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <h3>Total: €'.$totaal.'</h3>
                </div>
            </div>
        </div>
    </div>';
}
?>
</div>
</body>
</html>
