<?php

// Functies van de website
// Functie om de onderhoudsmodus te controleren
function onderhoudsModus($mysqli)
{

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
function controleerKlant($mysqli)
{
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

function controleerAdmin($mysqli)
{
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

function type($mysqli)
{
   session_start();
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
   header("Location: $paypalUrl?cmd=_xclick&business=$businessEmail&amount=$amount&currency_code=$currency&return=https://myshoes.zoobagogo.com/successBetalen&cancel_return=https://myshoes.zoobagogo.com/cancelBetalen");
   exit();
}
// function refundPayPalPayment($captureId, $amount)
// {
//    // PayPal API-gegevens (voor sandbox)
//    $clientId = 'YOUR_PAYPAL_CLIENT_ID';  // Vervang door je PayPal client-id
//    $secret = 'YOUR_PAYPAL_SECRET';  // Vervang door je PayPal secret
//    $sandboxUrl = 'https://api.sandbox.paypal.com';  // PayPal sandbox URL voor API-aanroepen

//    // Genereer een toegangstoken
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, $sandboxUrl . '/v1/oauth2/token');
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, CURLOPT_HTTPHEADER, [
//       'Accept: application/json',
//       'Accept-Language: en_US'
//    ]);
//    curl_setopt($ch, CURLOPT_USERPWD, $clientId . ':' . $secret);
//    curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
//    $response = curl_exec($ch);
//    if (curl_errno($ch)) {
//       die('Error:' . curl_error($ch));
//    }
//    $jsonResponse = json_decode($response);
//    $accessToken = $jsonResponse->access_token;
//    curl_close($ch);

//    // Creëer het refund-verzoek payload
//    $refundData = [
//       'amount' => [
//          'currency_code' => 'EUR',
//          'value' => $amount
//       ]
//    ];

//    // Maak de refund-aanroep naar PayPal
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, $sandboxUrl . '/v2/payments/captures/' . $captureId . '/refund');
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, CURLOPT_HTTPHEADER, [
//       'Content-Type: application/json',
//       'Authorization: Bearer ' . $accessToken
//    ]);
//    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($refundData));
//    $response = curl_exec($ch);
//    if (curl_errno($ch)) {
//       die('Error:' . curl_error($ch));
//    }
//    curl_close($ch);

//    // Verwerk de response van PayPal
//    $refundResponse = json_decode($response);

//    if (isset($refundResponse->status) && $refundResponse->status == 'COMPLETED') {
//       echo "Refund succesvol!";
//    } else {
//       echo "Refund mislukt: " . $refundResponse->message;
//    }
// }

// Functie om de Stripe betaling te verwerken

function processStripePayment($amount, $mysqli)
{
   session_start();
   $_SESSION['betaalmethode'] = "Stripe";
   require_once('stripe-php/init.php');

   $amount = str_replace(',', '', $amount);
   $amount = preg_replace('/\s+/', '', $amount);
   $amount = intval($amount);
   $amount = $amount * 100;

   $success_url = "https://myshoes.zoobagogo.com/successBetalen";
   $cancel_url = "https://myshoes.zoobagogo.com/cancelBetalen";


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
// function processStripeRefund($paymentIntentId)
// {
//    include 'connect.php';
//    session_start();

//    // Haal de Stripe secret key uit de database
//    $sql = "SELECT * FROM tblbetaalmethodes where methodenaam = 'Stripe'";
//    $result = $mysqli->query($sql);
//    $row = $result->fetch_assoc();
//    $stripe_secret_key = $row['sleutel'];

//    try {
//       \Stripe\Stripe::setApiKey($stripe_secret_key);

//       // Voer de terugbetaling uit
//       $refund = \Stripe\Refund::create([
//          'payment_intent' => $paymentIntentId, // Gebruik het Payment Intent ID dat je van de betaling hebt ontvangen
//       ]);

//       if ($refund->status == 'succeeded') {
//          // Terugbetaling is gelukt
//          echo 'Refund succesvol verwerkt!';
//       } else {
//          // Terugbetaling is niet geslaagd
//          echo 'Er is een probleem met de terugbetaling.';
//       }
//    } catch (\Stripe\Exception\ApiErrorException $e) {
//       // Foutafhandelingscode
//       echo 'Fout bij het verwerken van de terugbetaling: ' . $e->getMessage();
//    }
// }

function socialmedia($mysqli)
{
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
function announcement($mysqli)
{
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
function recensieGoedkeuren($recensie_id, $mysqli)
{

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
function recensieVerwijderen($recensie_id, $mysqli)
{
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
function recensieToevoegen($klant_id, $rating, $text, $artikel_id, $mysqli)
{

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
function addWebsiteReview($klant_id, $rating, $text, $mysqli)
{

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

function getStockStatus($artikel_id, $mysqli)
{
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

function getSchoenenVergelijking($schoen1, $schoen2, $mysqli)
{
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


function getMerkNaam($merk_id, $mysqli)
{
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

function getCategorieNaam($categorie_id, $mysqli)
{
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


function stockCheck($mysqli)
{
   //list of wich stock id is below 2
   $sql = "SELECT * FROM tblstock WHERE stock < 2";
   $result = $mysqli->query($sql);

   if ($result->num_rows == 0) {
      echo '<h4 style="color:green;">Alle stock is boven 2</h4>';
   } else {
      echo '<div class="alert alert-danger" role="alert">The following products are out of stock:<br>';
      echo '<table border="1">';
      echo '<tr>';
      echo '<th>Stock_id</th><th>Artikel</th><th>Schoenmaat</th><th>Stock</th>';
      echo '</tr>';
      if ($result) {
         while ($row = $result->fetch_assoc()) {
            $stock_id = $row['stock_id'];
            $sql = "SELECT * FROM tblkleur k,tblvariatie v,tblstock s, tblartikels 
        WHERE s.stock_id = $stock_id and v.variatie_id = s.variatie_id and v.artikel_id = s.artikel_id 
        and v.artikel_id = tblartikels.artikel_id and k.kleur_id = v.kleur_id";
            $result2 = $mysqli->query($sql);
            while ($row2 = $result2->fetch_assoc()) {
               echo '<tr>';
               echo '<td>' . $row2['stock_id'] . '</td>';
               echo '<td>' . $row2['artikelnaam'] . ' ' . $row2['kleur'] . '</td>';
               echo '<td>' . $row2['schoenmaat'] . '</td>';
               echo '<td style="color:red;">' . $row2['stock'] . '</td>';
               echo '</tr>';
            }
         }
         echo '</table>';
      }
   }
}



function getBestellingStatus($bestelling_id, $mysqli) {
   $sql = "SELECT status FROM tblbestellingen WHERE bestelling_id = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("i", $bestelling_id);
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
   $stmt->close();
   $mysqli->close();
   return $row ? $row['status'] : 'Unknown';
}

function updateBestellingStatus($verkoop_id, $nieuw_status, $mysqli) {
   $sql = "UPDATE tblaankoop SET status = ? WHERE verkoop_id = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("si", $nieuw_status, $verkoop_id);
   $stmt->execute();
   $stmt->close();
   $mysqli->close();
}

function getAlleBestellingen($mysqli) {

    $sql = "SELECT verkoop_id AS bestelling_id, klant_id, status FROM tblaankoop";
    $result = $mysqli->query($sql);
    $bestellingen = [];
    while ($row = $result->fetch_assoc()) {
        $bestellingen[] = $row;
    }
    $mysqli->close();
    return $bestellingen;
}

function getUsername($klant_id, $mysqli)
{
   $sql = "SELECT klantnaam FROM tblklant WHERE klant_id = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("i", $klant_id);
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
   $stmt->close();
   $mysqli->close();
   return $row ? $row['klantnaam'] : 'unknown';
}


function generererMaandelijksRapport($maand, $jaar, $mysqli) {
   // Fetch costs from tblaankoop
   $sqlCostAankoop = "SELECT verkoop_id, totaalbedrag AS cost, ontvangstdatum, status FROM tblaankoop 
                      WHERE status = 'closed' 
                      AND MONTH(ontvangstdatum) = ? AND YEAR(ontvangstdatum) = ?";
   $stmtCostAankoop = $mysqli->prepare($sqlCostAankoop);
   $stmtCostAankoop->bind_param("ii", $maand, $jaar);
   $stmtCostAankoop->execute();
   $resultCostAankoop = $stmtCostAankoop->get_result();
   $totalCost = 0;
   $costDetails = [];
   while ($row = $resultCostAankoop->fetch_assoc()) {
       $totalCost += $row['cost'];
       $costDetails[] = $row;
   }

   // Fetch costs and revenues from tblfacturen (only closed invoices)
   $sqlFacturen = "SELECT factuur_id, bedrag, vervaldatum, status FROM tblfacturen 
                   WHERE status = 'closed' 
                   AND MONTH(vervaldatum) = ? AND YEAR(vervaldatum) = ?";
   $stmtFacturen = $mysqli->prepare($sqlFacturen);
   $stmtFacturen->bind_param("ii", $maand, $jaar);
   $stmtFacturen->execute();
   $resultFacturen = $stmtFacturen->get_result();
   $totalRevenue = 0;
   $revenueDetails = [];
   while ($row = $resultFacturen->fetch_assoc()) {
       if ($row['bedrag'] < 0) {
           $totalCost += abs($row['bedrag']); // Add absolute value of negative costs
           $costDetails[] = $row;
           $totalRevenue += abs($row['bedrag']); // Add negative values to revenue as positive
       } else {
           $totalRevenue += $row['bedrag']; // Add positive values to revenues
           $revenueDetails[] = $row;
       }
   }

   // Fetch revenues from tblaankoop
   $sqlRevenue = "SELECT klant_id, SUM(totaalbedrag) AS revenue FROM tblaankoop 
                  WHERE MONTH(ontvangstdatum) = ? AND YEAR(ontvangstdatum) = ?
                  GROUP BY klant_id";
   $stmtRevenue = $mysqli->prepare($sqlRevenue);
   $stmtRevenue->bind_param("ii", $maand, $jaar);
   $stmtRevenue->execute();
   $resultRevenue = $stmtRevenue->get_result();
   while ($row = $resultRevenue->fetch_assoc()) {
       $totalRevenue += $row['revenue'];
       $revenueDetails[] = $row;
   }
   
   $profit = $totalRevenue - $totalCost;
   
   $stmtCostAankoop->close();
   $stmtFacturen->close();
   $stmtRevenue->close();
   $mysqli->close();
   
   return [
       'report' => array_merge($costDetails, $revenueDetails),
       'totalRevenue' => $totalRevenue,
       'totalCost' => $totalCost,
       'profit' => $profit
   ];
}

function genereerJaarliksRapport($jaar, $mysqli) {
   
   // Fetch costs from tblaankoop
   $sqlCostAankoop = "SELECT verkoop_id, klant_id, totaalbedrag AS cost, ontvangstdatum, status FROM tblaankoop 
                      WHERE status = 'closed' AND YEAR(ontvangstdatum) = ?";
   $stmtCostAankoop = $mysqli->prepare($sqlCostAankoop);
   $stmtCostAankoop->bind_param("i", $jaar);
   $stmtCostAankoop->execute();
   $resultCostAankoop = $stmtCostAankoop->get_result();
   $totalCost = 0;
   $costDetails = [];
   while ($row = $resultCostAankoop->fetch_assoc()) {
       $totalCost += $row['cost'];
       $costDetails[] = $row;
   }

   // Fetch costs and revenues from tblfacturen (only closed invoices)
   $sqlFacturen = "SELECT factuur_id, bedrag, vervaldatum, status FROM tblfacturen 
                   WHERE status = 'closed' 
                   AND YEAR(vervaldatum) = ?";
   $stmtFacturen = $mysqli->prepare($sqlFacturen);
   $stmtFacturen->bind_param("i", $jaar);
   $stmtFacturen->execute();
   $resultFacturen = $stmtFacturen->get_result();
   $totalRevenue = 0;
   $revenueDetails = [];
   while ($row = $resultFacturen->fetch_assoc()) {
       if ($row['bedrag'] < 0) {
           $totalCost += abs($row['bedrag']); // Add absolute value of negative costs
           $costDetails[] = $row;
           $totalRevenue += abs($row['bedrag']); // Add negative values to revenue as positive
       } else {
           $totalRevenue += $row['bedrag']; // Add positive values to revenues
           $revenueDetails[] = $row;
       }
   }

   // Fetch revenues from tblaankoop
   $sqlRevenue = "SELECT klant_id, SUM(totaalbedrag) AS revenue FROM tblaankoop 
                  WHERE YEAR(ontvangstdatum) = ?
                  GROUP BY klant_id";
   $stmtRevenue = $mysqli->prepare($sqlRevenue);
   $stmtRevenue->bind_param("i", $jaar);
   $stmtRevenue->execute();
   $resultRevenue = $stmtRevenue->get_result();
   while ($row = $resultRevenue->fetch_assoc()) {
       $totalRevenue += $row['revenue'];
       $revenueDetails[] = $row;
   }
   
   $profit = $totalRevenue - $totalCost;
   
   $stmtCostAankoop->close();
   $stmtFacturen->close();
   $stmtRevenue->close();
   $mysqli->close();
   
   return [
       'report' => array_merge($costDetails, $revenueDetails),
       'totalRevenue' => $totalRevenue,
       'totalCost' => $totalCost,
       'profit' => $profit
   ];
}

function getLeveringsDatum($bestelling_id, $mysqli) {
   $sql = "SELECT leveringsdatum FROM tblbestellingen WHERE bestelling_id = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("i", $bestelling_id);
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
   $stmt->close();
   $mysqli->close();
   return $row ? $row['leveringsdatum'] : 'Unknown';
}

function getBestellingstijd($bestelling_id, $mysqli) {
   $sql = "SELECT bestellingstijd FROM tblbestellingen WHERE bestelling_id = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("i", $bestelling_id);
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
   $stmt->close();
   $mysqli->close();
   return $row ? $row['bestellingstijd'] : 'Unknown';
}

function getAlleFacturen($mysqli) {

   $sql = "SELECT * FROM tblfacturen";
   $resultaat = $mysqli->query($sql);
   $facturen = [];
   while ($row = $resultaat->fetch_assoc()) {
       $facturen[] = $row;
   }
   $mysqli->close();
   return $facturen;
}

function getAllOrdersByCustomer($klant_id, $mysqli) {
   $sql = "SELECT bestelling_id, status, bestellingstijd, leveringsdatum 
           FROM tblbestellingen 
           WHERE klant_id = ? AND status != 'delivered' 
           ORDER BY bestellingstijd DESC";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("i", $klant_id);
   $stmt->execute();
   $result = $stmt->get_result();
   $orders = [];
   while ($row = $result->fetch_assoc()) {
       $orders[] = $row;
   }
   $stmt->close();
   $mysqli->close();
   return $orders;
}

function berekenKlantLevenswaarde($klant_id) {
   include 'connect.php';
   $sql = "SELECT SUM(totaalbedrag) AS total_spent FROM tblaankoop WHERE klant_id = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("i", $klant_id);
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
   $stmt->close();
   return $row['total_spent'];
}

function sluitFactuur($factuur_id, $mysqli) {

   $sql = "UPDATE tblfacturen SET status = 'closed' WHERE factuur_id = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("i", $factuur_id);
   $stmt->execute();
   $stmt->close();
   $mysqli->close();
}

function getBestellingenKlant($klant_id, $mysqli) {

   $sql = "SELECT verkoop_id AS bestelling_id, status, ontvangstdatum AS leveringsdatum 
           FROM tblaankoop 
           WHERE klant_id = ? AND status != 'afgeleverd' 
           ORDER BY ontvangstdatum DESC";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("i", $klant_id);
   $stmt->execute();
   $result = $stmt->get_result();
   $orders = $result->fetch_all(MYSQLI_ASSOC);
   $stmt->close();
   $mysqli->close();
   return $orders;
}
?>