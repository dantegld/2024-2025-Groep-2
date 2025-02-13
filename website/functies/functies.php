<?php

// Functies van de website
// Functie om de onderhoudsmodus te controleren
function onderhoudsModus()
{
   include 'connect.php';

   $sql = "SELECT functiewaarde FROM tbladmin where functienaam = 'onderhoudmodus'";
   $result = $mysqli->query($sql);
   $row = $result->fetch_assoc();
   if ($row) {
      $sql4 = "SELECT k.type_id ,t.type_id,t.type FROM tblklant k,tbltypes t WHERE klant_id = ?  and k.type_id = t.type_id";
      $stmt4 = $mysqli->prepare($sql4);
      $stmt4->bind_param("i", $_SESSION['klant_id']);
      $stmt4->execute();
      $result4 = $stmt4->get_result();
      $row4 = $result4->fetch_assoc();
      if ($row4 && $row["functiewaarde"] == 1 && $row4['type'] == "customer") {
         header("Location: onderhoudsPagina");
      }
   }
}

// Functie om de gebruiker te controleren
function controleerKlant()
{
   include 'connect.php';
   $sql = "SELECT k.type_id ,t.type_id,t.type FROM tblklant k,tbltypes t WHERE klant_id = ?  and k.type_id = t.type_id";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("i", $_SESSION['klant_id']);
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
   $type = $row['type'];


   if ((!($type == "customer") && !($type == "admin")) || !isset($_SESSION['klant_id'])) {
      header("Location: logout.php");
   }
}

function controleerAdmin()
{

   include 'connect.php';
   $sql = "SELECT k.type_id ,t.type_id,t.type FROM tblklant k,tbltypes t WHERE klant_id = ?  and k.type_id = t.type_id";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("i", $_SESSION['klant_id']);
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
   $type = $row['type'];


   if ((!($type == "admin")) || !isset($_SESSION['klant_id'])) {
      if ($type == "customer") {
         header("Location: index");
         exit();
      } else {
         header("Location: logout");
         exit();
      }
   }
}

function type()
{

   include 'connect.php';
   $sql = "SELECT k.type_id ,t.type_id,t.type FROM tblklant k,tbltypes t WHERE klant_id = ?  and k.type_id = t.type_id";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("i", $_SESSION['klant_id']);
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
   $type = $row['type'];
   return $type;
}

// Functie om de betaling te verwerken
function processPayPalPayment($amount)
{
   session_start();
   $_SESSION['betaalmethode'] = "PayPal"; 
   $amount = str_replace(",", "", $amount);
   // Redirect to PayPal payment page
   $paypalUrl = "https://sandbox.paypal.com";
   $businessEmail = "sb-b7xzb33227151@business.example.com";
   $currency = "EUR";


   // Redirect to PayPal with required fields NOG VERRANDEREN VOOR LIVE SERVER
   header("Location: $paypalUrl?cmd=_xclick&business=$businessEmail&amount=$amount&currency_code=$currency&return=https://groep2.itbusleyden.be/successBetalen.php&cancel_return=https://groep2.itbusleyden.be/cancelBetalen.php");
   exit();
}
function refundPayPalPayment($captureId, $amount)
{
    // PayPal API-gegevens (voor sandbox)
    $clientId = 'YOUR_PAYPAL_CLIENT_ID';  // Vervang door je PayPal client-id
    $secret = 'YOUR_PAYPAL_SECRET';  // Vervang door je PayPal secret
    $sandboxUrl = 'https://api.sandbox.paypal.com';  // PayPal sandbox URL voor API-aanroepen

    // Genereer een toegangstoken
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $sandboxUrl . '/v1/oauth2/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Accept-Language: en_US'
    ]);
    curl_setopt($ch, CURLOPT_USERPWD, $clientId . ':' . $secret);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        die('Error:' . curl_error($ch));
    }
    $jsonResponse = json_decode($response);
    $accessToken = $jsonResponse->access_token;
    curl_close($ch);

    // Creëer het refund-verzoek payload
    $refundData = [
        'amount' => [
            'currency_code' => 'EUR',
            'value' => $amount
        ]
    ];

    // Maak de refund-aanroep naar PayPal
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $sandboxUrl . '/v2/payments/captures/' . $captureId . '/refund');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($refundData));
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        die('Error:' . curl_error($ch));
    }
    curl_close($ch);

    // Verwerk de response van PayPal
    $refundResponse = json_decode($response);

    if (isset($refundResponse->status) && $refundResponse->status == 'COMPLETED') {
        echo "Refund succesvol!";
    } else {
        echo "Refund mislukt: " . $refundResponse->message;
    }
}

// Functie om de Stripe betaling te verwerken

function processStripePayment($amount)
{
   include 'connect.php';
   session_start();
   $_SESSION['betaalmethode'] = "Stripe"; 
   require_once('stripe-php/init.php');

   $amount = str_replace(',', '', $amount);
   $amount = preg_replace('/\s+/', '', $amount);
   $amount = intval($amount);
   $amount = $amount * 100;

   $success_url = "https://groep2.itbusleyden.be/successBetalen.php";
   $cancel_url = "https://groep2.itbusleyden.be/cancelBetalen.php";


   //get from database
   $sql = "SELECT * FROM tblbetaalmethodes where methodenaam = 'Stripe'";
   $result = $mysqli->query($sql);
   $row = $result->fetch_assoc();
   $stripe_secret_key = $row['sleutel'];

   try {
      \Stripe\Stripe::setApiKey($stripe_secret_key);
      $checkout_session = \Stripe\Checkout\Session::create([
         'mode' => "payment",
         'success_url' => $success_url,
         'cancel_url' => $cancel_url,
         'line_items' => [
            [
               "quantity" => 1,
               "price_data" => [
                  "currency" => "eur",
                  "unit_amount" => $amount, // in cents, NIET IN EURO NIET VERGETEN
                  "product_data" => [
                     "name" => "Schoenen",
                  ],
               ],
            ],
         ],
      ]);

      http_response_code(303);
      header('Location: ' . $checkout_session->url);
      exit();
   } catch (Exception $e) {

      echo 'Caught exception: ',  $e->getMessage(), "\n";
   }
}
function processStripeRefund($paymentIntentId)
{
   include 'connect.php';
   session_start();
   
   // Haal de Stripe secret key uit de database
   $sql = "SELECT * FROM tblbetaalmethodes where methodenaam = 'Stripe'";
   $result = $mysqli->query($sql);
   $row = $result->fetch_assoc();
   $stripe_secret_key = $row['sleutel'];

   try {
      \Stripe\Stripe::setApiKey($stripe_secret_key);

      // Voer de terugbetaling uit
      $refund = \Stripe\Refund::create([
         'payment_intent' => $paymentIntentId, // Gebruik het Payment Intent ID dat je van de betaling hebt ontvangen
      ]);

      if ($refund->status == 'succeeded') {
         // Terugbetaling is gelukt
         echo 'Refund succesvol verwerkt!';
      } else {
         // Terugbetaling is niet geslaagd
         echo 'Er is een probleem met de terugbetaling.';
      }
   } catch (\Stripe\Exception\ApiErrorException $e) {
      // Foutafhandelingscode
      echo 'Fout bij het verwerken van de terugbetaling: ' . $e->getMessage();
   }
}

function socialmedia()
{
   include 'connect.php';

   $sql = "SELECT * FROM tblsocialmedia WHERE beschikbaar = 1";
   if ($stmt = $mysqli->prepare($sql)) {
      $stmt->execute();
      $result = $stmt->get_result();

      while ($row = $result->fetch_assoc()) {
         echo '<br><a href="' . htmlspecialchars($row['link'], ENT_QUOTES, 'UTF-8') . '">
            <img width="22px" src="' . htmlspecialchars($row['icoon'], ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($row['socialmedianaam'], ENT_QUOTES, 'UTF-8') . '">
            ' . htmlspecialchars($row['socialmedianaam'], ENT_QUOTES, 'UTF-8') .  '</a>';
      }

      $stmt->close();
   } else {
      echo "Error: " . $mysqli->error;
   }

   $mysqli->close();
}

// Functie om aankondigingen te tonen
function announcement()
{
   // Verbind met de database
   include 'connect.php';

   // Haal alle aankondigingen op uit de database
   $sql = "SELECT * FROM tblannouncement WHERE announcement_id = 1";
   $result = $mysqli->query($sql);

   // Controleer of er aankondigingen zijn
   if ($result->num_rows == 0) {
      // Geen aankondigingen gevonden, log dit in de console
      print("<script>console.log('No announcement found');</script>");
      return;
   } else {
      // Toon elke aankondiging als een popup
      while ($row = $result->fetch_assoc()) {
         // HTML voor de popup
         echo '
           <div class="popupBackground" id="popupBackground">
           <div class="popup" id="popup">
           <div class="popup-content">
             <span class="close" onclick="closePopup()">&times;</span>
             <p>' . htmlspecialchars($row['announcement'], ENT_QUOTES, 'UTF-8') . '</p>
           </div>
          </div>
          </div>';


         $mysqli->close();
      }


      //recenties pakken
      // JavaScript functie om de popup te sluiten
      echo '<script>
         function closePopup() {
            var popup = document.getElementById("popup");
            var popupBackground = document.getElementById("popupBackground");
            popup.style.display = "none";
            popupBackground.style.display = "none";
           }
           </script>';

      // JavaScript om de popup te tonen bij het laden van de pagina
      echo '<script>
           window.onload = function() {
            var popup = document.getElementById("popup");
            var popupBackground = document.getElementById("popupBackground");
            popup.style.display = "block";
           }
           </script>';

      // CSS voor de popup styling
      echo '<style>
             .popupBackground {
                position: fixed;
                top:  0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                display: flex;
                justify-content: center;
                align-items: start;
                padding-top: 50px;
                z-index: 1000;
               }

           .popup-content {
               display: flex;
               position: relative;
               background-color: #fff;
               justify-content: center;
               align-items: center;
               padding-left: 200px;
               padding-right: 200px;
               padding-top: 50px;
               padding-bottom: 50px;
               border-radius: 10px;
               box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
               max-width: 500px;
               width: 80%;
               text-align: center;
           }

           .close {
             position: absolute;
             top: 25px;
             right: 30px;
             font-size: 30px;
             cursor: pointer;
           }
           </style>';
   }
}
// Sluit de databaseverbinding

// Functie om een recensie goed te keuren
function recensieGoedkeuren($recensie_id)
{
   include 'connect.php'; // Zorg dat connect.php de $mysqli variabele bevat
   global $mysqli;

   // Update-query om een recensie goed te keuren
   $sql = "UPDATE tblrecensies SET goedGekeurd = 1 WHERE recensie_id = ?";
   $stmt = $mysqli->prepare($sql);

   if (!$stmt) {
      die("Fout bij voorbereiden van statement: " . $mysqli->error);
   }

   // Bind de parameter en voer de query uit
   $stmt->bind_param("i", $recensie_id);

   if (!$stmt->execute()) {
      die("Fout bij uitvoeren van statement: " . $stmt->error);
   }

   $stmt->close();
}

// Functie om een recensie te verwijderen
function recensieVerwijderen($recensie_id)
{
   include 'connect.php'; // Zorg dat connect.php de $mysqli variabele bevat
   global $mysqli;

   // Delete-query om een recensie te verwijderen
   $sql = "DELETE FROM tblrecensies WHERE recensie_id = ?";
   $stmt = $mysqli->prepare($sql);

   if (!$stmt) {
      die("Fout bij voorbereiden van statement: " . $mysqli->error);
   }

   // Bind de parameter en voer de query uit
   $stmt->bind_param("i", $recensie_id);

   if (!$stmt->execute()) {
      die("Fout bij uitvoeren van statement: " . $stmt->error);
   }

   $stmt->close();
}

// Functie om een recensie toe te voegen
function recensieToevoegen($klant_id, $rating, $text, $artikel_id)
{
   include 'connect.php'; // Zorg dat $mysqli beschikbaar is
   global $mysqli;

   // De SQL-query aanpassen aan de bestaande kolommen
   $sql = "INSERT INTO tblrecensies (klant_id, rating, text, goedGekeurd, artikel_id) VALUES (?, ?, ?, 0, ?)";
   $stmt = $mysqli->prepare($sql);

   if (!$stmt) {
      die("Fout bij voorbereiden van statement: " . $mysqli->error);
   }

   // Parameters binden en de query uitvoeren
   $stmt->bind_param("iisi", $klant_id, $rating, $text, $artikel_id);

   if (!$stmt->execute()) {
      die("Fout bij uitvoeren van statement: " . $stmt->error);
   }

   $stmt->close();
}

// Functie om een website recensie toe te voegen
function addWebsiteReview($klant_id, $rating, $text) {
   include 'connect.php';
   $sql = "INSERT INTO tblwebsitefeedback (klant_id, rating, text) VALUES (?, ?, ?)";
   $stmt = $mysqli->prepare($sql);

   if (!$stmt) {
       die("Fout bij voorbereiden van statement: " . $mysqli->error);
   }

   $stmt->bind_param("iis", $klant_id, $rating, $text);

   if (!$stmt->execute()) {
       die("Fout bij uitvoeren van statement: " . $stmt->error);
   }

   $stmt->close();
   $mysqli->close();
}

function getStockStatus($artikel_id)
{
   include 'connect.php';
   $sql = "SELECT stock FROM tblstock WHERE artikel_id = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("i", $artikel_id);
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();

   if ($row === null) {
      return 'Out of stock';
   }

   return $row['stock'] > 0 ? 'In Stock' : 'Out of Stock';
}

function getSchoenenVergelijking($schoen1, $schoen2)
{
   include 'connect.php';
   $sql = "SELECT * FROM tblartikels WHERE artikel_id IN (?, ?)";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("ii", $schoen1, $schoen2);
   $stmt->execute();
   $result = $stmt->get_result();
   $schoenen = [];
   while ($row = $result->fetch_assoc()) {
      $schoenen[] = $row;
   }
   $stmt->close();
   $mysqli->close();
   return $schoenen;
}


function getMerkNaam($merk_id) {
    include 'connect.php';
    $sql = "SELECT merknaam FROM tblmerk WHERE merk_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $merk_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    $mysqli->close();
    return $row ? $row['merknaam'] : 'unknown';
}

function getCategorieNaam($categorie_id) {
    include 'connect.php';
    $sql = "SELECT categorienaam FROM tblcategorie WHERE categorie_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $categorie_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    $mysqli->close();
    return $row ? $row['categorienaam'] : 'unknown';
}


function stockCheck()
{
   include 'connect.php';
   $outOfStock = [];

   $sql = "SELECT artikel_id, artikelnaam FROM tblartikels WHERE artikel_id NOT IN (SELECT artikel_id FROM tblstock WHERE stock > 0)";
   $result = $mysqli->query($sql);



   if ($result) {
      while ($row = $result->fetch_assoc()) {
         $outOfStock[] = $row;
      }
      $result->close();
   }

   if (!empty($outOfStock)) {

      echo '<div class="alert alert-danger" role="alert">
         The following products are out of stock:<br>
      ';

      foreach ($outOfStock as $product) {
         echo htmlspecialchars($product['artikelnaam'], ENT_QUOTES, 'UTF-8') . "<br>";

      }
      echo '</div>';


   } else {
   ?>
      <div class="alert alert-success" role="alert">
         All products are in stock.
      </div>
   <?php
   }

   $mysqli->close();
}


function getOrderStatus($order_id) {
   include 'connect.php';
   $sql = "SELECT status FROM tblorders WHERE order_id = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("i", $order_id);
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
   $stmt->close();
   $mysqli->close();
   return $row ? $row['status'] : 'Unknown';
}

function updateOrderStatus($order_id, $new_status) {
   include 'connect.php';
   $sql = "UPDATE tblorders SET status = ? WHERE order_id = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("si", $new_status, $order_id);
   $stmt->execute();
   $stmt->close();
   $mysqli->close();
}

function getAllOrders() {
  include 'connect.php';
  $sql = "SELECT * FROM tblorders";
  $result = $mysqli->query($sql);
  $orders = [];
  while ($row = $result->fetch_assoc()) {
      $orders[] = $row;
  }
  $mysqli->close();
  return $orders;
}

?>