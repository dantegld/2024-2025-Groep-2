<?php

// Functies van de website
// Functie om de onderhoudsmodus te controleren
function onderhoudsModus()
{
   include 'connect.php';
   
   

   $sql = "SELECT functiewaarde FROM tbladmin where functienaam = 'onderhoudmodus'";
   $result = $mysqli->query($sql);
   $row = $result->fetch_assoc();
   $sql4 = "SELECT type FROM tblklant WHERE klant_id = ? ";
   $stmt4 = $mysqli->prepare($sql4);
   $stmt4->bind_param("i", $_SESSION['klant_id']);
   $stmt4->execute();
   $result4 = $stmt4->get_result();
   $row4 = $result4->fetch_assoc();
   if ($row["functiewaarde"] == 1 && $row4['type'] == "customer") {
      header("Location: onderhoudsPagina.php");
   }
}

// Functie om de gebruiker te controleren
function controleerKlant()
{
   include 'connect.php';
   $sql = "SELECT type FROM tblklant WHERE klant_id = ?";
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
   $sql = "SELECT type FROM tblklant WHERE klant_id = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("i", $_SESSION['klant_id']);
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
   $type = $row['type'];


   if ((!($type == "admin")) || !isset($_SESSION['klant_id'])) {
      if($type == "customer"){
         header("Location: index.php");
      }else{
      header("Location: logout.php");
      }
   }
}

// Functie om de betaling te verwerken
function processPayPalPayment($amount)
{
   session_start();

   $amount = str_replace(",", "", $amount);
   // Redirect to PayPal payment page
   $paypalUrl = "https://sandbox.paypal.com";
   $businessEmail = "sb-b7xzb33227151@business.example.com";
   $currency = "EUR";


   // Redirect to PayPal with required fields NOG VERRANDEREN VOOR LIVE SERVER
   header("Location: $paypalUrl?cmd=_xclick&business=$businessEmail&amount=$amount&currency_code=$currency&return=https://groep2.itbusleyden.be/successBetalen.php&cancel_return=https://groep2.itbusleyden.be/cancelBetalen.php");
   exit();
}


// Functie om de Stripe betaling te verwerken

function processStripePayment($amount){
   include 'connect.php';
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

  } catch (Exception $e) {

      echo 'Caught exception: ',  $e->getMessage(), "\n";
  }
}

function socialmedia() {
    include 'connect.php';

    $sql = "SELECT * FROM tblsocialmedia WHERE beschikbaar = 1";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            echo '<br><a href="' . htmlspecialchars($row['link'], ENT_QUOTES, 'UTF-8') . '">
            <img width="22px" src="' . htmlspecialchars($row['icoon'], ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($row['socialmedianaam'], ENT_QUOTES, 'UTF-8') . '">
            '. htmlspecialchars($row['socialmedianaam'], ENT_QUOTES, 'UTF-8') .  '</a>';
        }

        $stmt->close();
    } else {
        echo "Error: " . $mysqli->error;
    }

    $mysqli->close();

    
}


//recenties pakken
function recensiePakken($klant_id)
{
   include 'connect.php';
  $sql = "SELECT * FROM tblrecensies WHERE klant_id = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("i", $klant_id);
  $stmt->execute();
  $result = $stmt->get_result();
  return $result;
}

// Functie om een recensie goed te keuren
function recensieGoedkeuren($recensie_id) {
   include 'connect.php';
   $sql = "UPDATE tblrecensies SET goedGekeurd = 1 WHERE recensie_id = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("i", $recensie_id);
   $stmt->execute();
   $stmt->close();
}

// recensie toevoegen
function recensieToevoegen($klant_id, $artikel_id, $rating, $text) {
   include 'connect.php';
   $sql = "INSERT INTO tblrecensies (text, rating, klant_id, artikel_id, goedGekeurd) VALUES (?, ?, ?, ?, 0)";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("siii", $text, $rating, $klant_id, $artikel_id);
   $stmt->execute();
   $stmt->close();
}