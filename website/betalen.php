<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Afrekenen</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
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
<?php
error_reporting(E_ALL & ~E_NOTICE);
include 'connect.php';
session_start();
include 'functies/functies.php';
onderhoudsModus();
controleerKlant();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

// Haal totaalbedrag op uit de sessie
$totaal = $_SESSION['total_price'];

echo '
<div class="loginFormLocatie">
    <div class="loginForm">';

    $totaal = $_SESSION['total_price'];

    // Verwijder de komma's en zet de waarde om naar een float
    $totaal = (float) str_replace(',', '', $totaal);
    
    // Debug: Controleer de waarde van $totaal

    
    // Haal de hoogste kortingscode op
    $sqlDiscount = "SELECT * FROM `tblkortingscodes` ORDER BY korting_euro DESC LIMIT 1";
    $resultDiscount = $mysqli->query($sqlDiscount);
    while ($row = $resultDiscount->fetch_assoc()) {
        $discountPrice = (float) $row['korting_euro'];  
        // Controleer de waarde van het kortingspercentage
    // Dit zou het kortingspercentage moeten zijn
    
        // Pas de korting toe op het totaalbedrag als het percentage geldig is
        if (!($row['einddatum'] < date("Y-m-d"))) {
            // Pas de korting toe (korting is altijd een percentage)
            $totaal = $totaal * (1 - $discountPrice / 100);  // Verminder de prijs met het percentage
        }
    }
    
    // Debugging: Bekijk de nieuwe waarde van $totaal na de korting

// Laat de waarde van $discountPrice zien

// Als de betaling is gedaan
if (isset($_POST['betalen'])) {
    $payment_method = $_POST['payment_method'];
    $payment_method = strtolower($payment_method);

    if ($payment_method == 'paypal') {
        processPayPalPayment($totaal);
    } else if ($payment_method == 'stripe') {
        processStripePayment($totaal);
    } else {
        echo "Invalid payment method selected.";
        die;
    }

    //Neem email van de klant
    $sql = "SELECT email FROM tblklant WHERE klant_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_SESSION['klant_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $email = $row['email'];

    // PHPMailer
    $mail = new PHPMailer(true);

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
        $mail->Subject = 'Payment Confirmation';
        $mail->Body    = 'Dear customer,<br><br>Thank you for your payment of €' . number_format($totaal, 2) . '.<br><br>Best regards,<br>Your Company';
        $mail->AltBody = 'Dear customer,\n\nThank you for your payment of €' . number_format($totaal, 2) . '.\n\nBest regards,\nYour Company';

        // verzend de email
        $mail->send();
        echo 'Payment successful. A confirmation email has been sent to your email address.';
    } catch (Exception $e) {
        echo "Payment successful. However, we could not send a confirmation email. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    // Toon het betalingsformulier
    echo "
    <form action='betalen' method='post'>
    <h3>Total price: €" . number_format($totaal, 2) . "</h3>
    <input type='hidden' name='amount' value='$totaal'>
    <div class='payment-methods'>
    ";

    // Verkrijg de beschikbare betaalmethodes
    $sql = "SELECT * FROM tblbetaalmethodes WHERE actief = 1";
    $result = $mysqli->query($sql);
    if ($result->num_rows == 0) {
        echo "<p>No payment methods available at the moment. Please try again later or contact customer service.</p>";
    } else {
        echo "<h4>Select a payment method:</h4>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='payment-option'>
                    <input type='radio' name='payment_method' value='" . $row['methodenaam'] . "'> " . $row['methodenaam'] . "
                  </div>";
        }
        echo "<br><input type='submit' value='Pay now' name='betalen' class='btn btn-primary'>";
        echo "</div></form>";
    }
}

echo ' </div>
</div>';
?>
