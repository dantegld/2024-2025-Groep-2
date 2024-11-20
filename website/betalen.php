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

<body>
    <?php
    error_reporting(E_ALL & ~E_NOTICE);
    include 'connect.php';
    session_start();
    include 'functies/functies.php';
    onderhoudsModus();
    controleerKlant();


    $totaal = $_SESSION['total_price'];
echo '
<div class="loginFormLocatie">
        <div class="loginForm">';
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
            } else {
                echo "
                <form action='betalen' method='post'>
                <br>
                <h3>Total price: €$totaal</h3>
                <input type='hidden' name='amount' value='$totaal'>
                ";
                $sql = "SELECT * FROM tblbetaalmethodes WHERE actief = 1";
                $result = $mysqli->query($sql);
                if ($result->num_rows == 0) {
                    echo "Geen betaalmethodes beschikbaar op dit moment. Probeer het later opnieuw of neem contact op met de klantenservice.";
                } else {
                    echo "<h3>Select a payment method:</h3>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<input type='radio' name='payment_method' value='" . $row['methodenaam'] . "'>" . ' ' . $row['methodenaam'] . "<br>";
                    }
                    echo "<br><input type='submit' value='Pay now' name='betalen' class='btn btn-primary'>";
                    echo "</form>";
                }
            }
       echo ' </div>
</div>';
    ?>
</body>