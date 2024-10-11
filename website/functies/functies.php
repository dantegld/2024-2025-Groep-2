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
   session_start();

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
   header("Location: $paypalUrl?cmd=_xclick&business=$businessEmail&amount=$amount&currency_code=$currency&return=http://localhost/tiago/2024-2025-Groep-2/2024-2025-Groep-2/website/winkelwagen.php&cancel_return=http://localhost/tiago/2024-2025-Groep-2/2024-2025-Groep-2/website/cancelBetalen.php");
   exit();
}


// Functie om de Stripe betaling te verwerken

function processStripePayment($amount)
{
   require_once('stripe-php/init.php');

   $amount = $amount * 100;
   $amount = str_replace(',', '', $amount);
   $amount = preg_replace('/\s+/', '', $amount);

   $success_url = "http://localhost/tiago/2024-2025-Groep-2/2024-2025-Groep-2/website/successBetalen.php";
   $cancel_url = "http://localhost/tiago/2024-2025-Groep-2/2024-2025-Groep-2/website/cancelBetalen.php";

   $stripe_secret_key = 'sk_test_51Q8kjWPPG2zVDYrhIRAkxlWQJ2pOwUHLLBctHjfbVJvnxZM9CqGmnD455lWASCk2IaaDqmiETmGxZA9PlNozsnAd00whdJmWl0';

   \Stripe\Stripe::setApiKey($stripe_secret_key);
   $checkout_session = \Stripe\Checkout\Session::create([
      'payment_method_types' => "payment",
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




}



