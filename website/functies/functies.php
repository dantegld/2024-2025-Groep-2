<?php

// Functies van de website
header("../website/index.php");
// Functie om de onderhoudsmodus te controleren
function onderhoudsModus()
{
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
function controleerKlant()
{

   if ($_SESSION['klant'] == FALSE) {
      header("Location: logout.php");
   }
}

function controleerAdmin()
{
   session_start();

   if ($_SESSION['klant'] && $_SESSION['admin'] == FALSE) {
      header("Location: index.php");
   } else if ($_SESSION['klant'] == FALSE) {
      header("Location: logout.php");
   }
}

function controleerEigenaar()
{
   session_start();

   if ($_SESSION['eigenaar'] == FALSE && $_SESSION['klant'] && $_SESSION['admin'] == FALSE) {
      header("Location: index.php");
   } else if ($_SESSION['klant'] == FALSE) {
      header("Location: logout.php");
   } else if ($_SESSION['admin'] == FALSE) {
      header("Location: admin.php");
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
   header("Location: $paypalUrl?cmd=_xclick&business=$businessEmail&amount=$amount&currency_code=$currency&return=http://localhost/tiago/2024-2025-Groep-2/website/winkelwagen.php&cancel_return=http://localhost/tiago/2024-2025-Groep-2/website/cancelBetalen.php");
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

   $success_url = "http://localhost/tiago/2024-2025-Groep-2/website/successBetalen.php";
   $cancel_url = "http://localhost/tiago/2024-2025-Groep-2/website/cancelBetalen.php";


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
            '. htmlspecialchars($row['socialmedianaam'], ENT_QUOTES, 'UTF-8') .  '</a><br>';
        }

        $stmt->close();
    } else {
        echo "Error: " . $mysqli->error;
    }

    $mysqli->close();
}