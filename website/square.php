<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afrekenen</title>
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Square Payment Form</title>
    <!-- Include Square Payment Form JavaScript library -->
    <script type="text/javascript" src="https://js.squareup.com/v2/paymentform"></script>
</head>
<body>
    <?php
    error_reporting(E_ALL & ~E_NOTICE);
    include 'connect.php';
    include 'functies/functies.php';
    onderhoudsModus();
    controleerKlant();


    if (isset($_POST['betalen'])) {
        processSquarePayment($totaal, $_POST['card-nonce']);
    } else {

    ?>
    <h1>Payment Form</h1>
    <form action="square.php" method="POST">
        <label for="card-number">Card Number:</label>
        <input type="text" id="card-number" name="card_number" required placeholder="Card Number"><br>

        <label for="expiration-date">Expiration Date (MM/YY):</label>
        <input type="text" id="expiration-date" name="expiration_date" required placeholder="MM/YY"><br>

        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" required placeholder="CVV"><br>

        <label for="postal-code">Postal Code:</label>
        <input type="text" id="postal-code" name="postal_code" required placeholder="Postal Code"><br>

        <input type="hidden" name="amount" value="<?php $_SESSION['total_price'] ?>"> <!-- Amount to charge -->
        <button type="submit" name="betalen">Pay</button>
    </form>
</body>
</html>

    <script type="text/javascript">
        // JavaScript code to handle the Square Payment Form
        function onGetCardNonce(event) {
            event.preventDefault();
            paymentForm.requestCardNonce();
        }

        const paymentForm = new SqPaymentForm({
            // Replace with your Square application ID and location ID
            applicationId: 'sandbox-sq0idb-4jGtnSlur-Zm4ENthKhyZw',
            locationId: 'L26P8QV01WFZS',
            inputClass: 'sq-input',
            autoBuild: false, // Prevents automatic building; build manually
            cardNumber: {
                elementId: 'sq-card-number',
                placeholder: 'Card Number'
            },
            cvv: {
                elementId: 'sq-cvv',
                placeholder: 'CVV'
            },
            expirationDate: {
                elementId: 'sq-expiration-date',
                placeholder: 'MM/YY'
            },
            postalCode: {
                elementId: 'sq-postal-code',
                placeholder: 'Postal Code'
            },
            // Callbacks for Square Payment Form
            callbacks: {
                cardNonceResponseReceived: function (errors, nonce, cardData) {
                    if (errors) {
                        // Display the first error message in the console
                        console.error('Encountered errors:');
                        errors.forEach(function(error) {
                            console.error(error.message);
                        });
                        alert(errors[0].message); // Display first error message to the user
                        return;
                    }
                    // Set the nonce value to the hidden form field
                    document.getElementById('card-nonce').value = nonce;
                    console.log('Nonce generated:', nonce);
                    // Submit the form
                    document.getElementById('payment-form').submit();
                }
            }
        });

        // Manually build the form after initializing
        paymentForm.build();
    </script>
    <?php
    }
    ?>


</body>
</html>
