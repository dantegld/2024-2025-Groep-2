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
controleerKlant(); // Controleer of klant is ingelogd
onderhoudsModus();
include 'functies/mySideNav.php';
echo '<br><span class="toggle_icon1" onclick="openNav()"><img width="44px" src="images/icon/Hamburger_icon.svg.png"></span>';

// PayPal en Stripe API-sleutels (Vervang deze met je echte sleutels)
require 'vendor/autoload.php'; // Zorg ervoor dat Stripe is geïnstalleerd via Composer
// \Stripe\Stripe::setApiKey('jouw_stripe_secret_key');

// $paypalClientId = "jouw_paypal_client_id";
// $paypalSecret = "jouw_paypal_secret";

// ✅ **Retour goedkeuren en terugbetaling uitvoeren**
if (isset($_POST['approve'])) {
    $klant_id = $_SESSION['klant_id'];  // Verondersteld dat de klant is ingelogd

    $sql = "SELECT verkoop_id FROM tblaankoop WHERE klant_id = $klant_id LIMIT 1";
    $result = $mysqli->query($sql);
    while ($row = mysqli_fetch_array($result)) {
        $verkoop_id = $row['verkoop_id'];

    }
// Haal de retourdatum op uit de database voor de opgegeven verkoop_id
$sql = "SELECT verkoop_id, RetourDatum FROM tblGeretourneerdeProducten WHERE verkoop_id = $verkoop_id LIMIT 1";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    // Als er een resultaat is, haal de verkoop_id en RetourDatum op
    $row = $result->fetch_assoc();
    $retourDatum = $row['RetourDatum'];
    $verkoop_id = $row['verkoop_id'];

    // Haal de huidige datum op
    $huidigeDatum = date('Y-m-d');

    // Zet de retourdatum om naar een timestamp (aantal seconden sinds 1970)
    $retourTimestamp = strtotime($retourDatum);
    $huidigeTimestamp = strtotime($huidigeDatum);

    // Bereken het aantal dagen tussen de retourdatum en de huidige datum
    $aantalDagenNaRetour = ($huidigeTimestamp - $retourTimestamp) / (60 * 60 * 24);
/*
    // Controleer of de terugbetaling binnen 30 dagen na de retourdatum kan plaatsvinden
    if ($aantalDagenNaRetour <= 30) {
        $sql = "SELECT verkoop_id, betaalmethode FROM tblaankoop  WHERE verkoop_id = $verkoop_id AND klant_id = $klant_id";
        $result = $mysqli->query($sql);
        while ($row = mysqli_fetch_array($result)) {
            $betaalmethode = $row['betaalmethode'];
        }
        if($betaalmethode == "PayPal") {
            refundPayPalPayment($captureId, $amount);
        } else {
            processStripeRefund($paymentIntentId);
        }
    } else {
        echo "Het retourtermijn voor terugbetaling is verstreken. Aantal dagen sinds retourdatum: $aantalDagenNaRetour";
    }
    */
} else {
    // Als er geen resultaat is voor de opgegeven verkoop_id
    echo "Geen retourdatum gevonden voor de opgegeven verkoop_id: $verkoop_id.";
}
   

}

// ❌ **Retourverzoek afwijzen**
if (isset($_POST['reject'])) {
    $retour_id = $_POST['retour_id'];

    $queryDelete = "DELETE FROM tblGeretourneerdeProducten WHERE retour_id = ?";
    $stmt = mysqli_prepare($mysqli, $queryDelete);
    mysqli_stmt_bind_param($stmt, "i", $retour_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo "<div class='alert alert-warning'>Retour afgewezen.</div>";
}

// ✅ **Haal alle retourverzoeken op**
// ✅ **Haal alle retourverzoeken op**
$query = "SELECT * FROM tblGeretourneerdeProducten";
$result = mysqli_query($mysqli, $query);

while ($row = mysqli_fetch_array($result)) {
    $artikel_id = $row['artikel_id'];

    // ✅ **Haal productinformatie op**
    $queryArtikel = "SELECT * FROM tblartikels WHERE artikel_id = '$artikel_id'";
    $resultArtikel = mysqli_query($mysqli, $queryArtikel);
    $rowArtikel = mysqli_fetch_array($resultArtikel);

    // ✅ **Haal ontvangstdatum van de bestelling**
    $verkoop_id = $row['verkoop_id'];
    $queryOntvangstdatum = "SELECT ontvangstdatum FROM tblaankoop WHERE verkoop_id = '$verkoop_id'";
    $resultOntvangstdatum = mysqli_query($mysqli, $queryOntvangstdatum);
    $rowOntvangstdatum = mysqli_fetch_array($resultOntvangstdatum);
    $ontvangstdatum = $rowOntvangstdatum['ontvangstdatum'];

   
        // ✅ **Totaalprijs berekenen**
        // $totaal = $rowArtikel['prijs'] * $row['aantal'];

        echo '<div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Retour #'.$row['retour_id'].'</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Customer ID</th>
                                        <th>Order ID</th>
                                        <th>Date of Reciept</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>'.$rowArtikel['artikelnaam'].'</td>
                                        <td>€'.$rowArtikel['prijs'].'</td>
                                        <td>'.$row['klant_id'].'</td>
                                        <td>'.$row['verkoop_id'].'</td>
                                        <td>'.$ontvangstdatum.'</td>

                                        <td>
                                            <form method="POST" action="">
                                                <input type="hidden" name="retour_id" value="'.$row['retour_id'].'">
                                                <button type="submit" name="approve" class="btn btn-success">Approve</button>
                                                <button type="submit" name="reject" class="btn btn-danger">Reject</button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div>';
    }

?>


</div>
</body>