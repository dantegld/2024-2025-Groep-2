<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you!</title>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Thank you!</title>
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
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <link rel="icon" href="images/icon/favicon.png">
</head>

<body>
    <?php
    include 'connect.php';
    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor/autoload.php';

    // Neem email van de klant
    $sql = "SELECT email FROM tblklant WHERE klant_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_SESSION['klant_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $email = $row['email'];
    $stmt->close();

    // PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Host, wachtwoord, gebruikersnaam, etc.
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  
        $mail->SMTPAuth = true;
        $mail->Username = 'contactmyshoes2800@gmail.com';  
        $mail->Password = 'pztvrfzhcksiqzhq';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;  

        // zender en ontvanger
        $mail->setFrom('myshoes@zoobagogo.com', 'Myshoes');  
        $mail->addAddress($email);  

        // inhoud van de email
        $mail->isHTML(true);
        $mail->Subject = 'Payment Confirmation';
        $mail->Body    = 'Dear customer,<br><br>Thank you for your payment.<br><br>Best regards,<br>Your Company';
        $mail->AltBody = 'Dear customer,\n\nThank you for your payment.\n\nBest regards,\nYour Company';

        // verzend de email
        $mail->send();
        echo 'Payment successful. A confirmation email has been sent to your email address.';
    } catch (Exception $e) {
        echo "Payment successful. However, we could not send a confirmation email. Mailer Error: {$mail->ErrorInfo}";
    }
 
        // Verkrijg klant_id uit de sessie
        $klant_id = $_SESSION['klant_id'];

        // Verkrijg winkelwagentijd gegevens van de klant
        $sql = "SELECT * FROM tblwinkelwagen WHERE klant_id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $klant_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Controleer of er artikelen in de winkelwagen zijn
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Verkrijg de gegevens van de winkelwagentabellen
                $artikel_id = $row['artikel_id'];
                $aantal = $row['aantal'];
                $variatie_id = $row['variatie_id'];

                // Verkrijg het adres van de klant uit tbladres
                $sqlAdres = "SELECT * FROM tbladres WHERE klant_id = ?";
                $stmtAdres = $mysqli->prepare($sqlAdres);
                $stmtAdres->bind_param("i", $klant_id);
                $stmtAdres->execute();
                $resultAdres = $stmtAdres->get_result();
                $rowAdres = $resultAdres->fetch_assoc();

                if ($rowAdres) {
                    $adres_id = $rowAdres['adres_id'];
                    $adres = $rowAdres['adres']; // Het adres van de klant
                } else {
                    // Foutmelding als er geen adres gevonden is
                    echo "Er is geen adres gevonden voor de klant.";
                    die;
                }

                // Verkrijg de ontvangstdatum (2 dagen vanaf nu)
                $ontvangstdatum = "NOW() + INTERVAL 2 DAY"; // Ontvangstdatum is 2 dagen na de huidige datum

                // Voeg de bestelling toe aan de tblaankoop tabel
                $status = 'verzonden'; // Stel status in op 'betald' na betaling

                // Voeg bestelling in de tblaankoop tabel
                $sql = "INSERT INTO tblaankoop (klant_id, artikel_id, variatie_id, aantal, adres_id, totaalbedrag, betaalmethode, status, persoonlijk_bericht, ontvangstdatum) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW() + INTERVAL 2 DAY)";

                $stmt2 = $mysqli->prepare($sql);
                $stmt2->bind_param("iiiiidssss", $klant_id, $artikel_id, $variatie_id, $aantal, $adres_id, $totaal, $payment_method, $status, $personal_message);

                if ($stmt2->execute()) {
                    echo "Bestelling voor artikel ID: $artikel_id succesvol opgeslagen.<br>";
                } else {
                    echo "Fout bij het opslaan van bestelling voor artikel ID: $artikel_id - " . $stmt2->error . "<br>";
                }
            }
        } else {
            echo "Je winkelwagen is leeg.";
        }
   /*if($_SESSION['betaalmethode'] == 'Stripe') {
        $type = "Stripe";
    } else {
        $type = "Paypal";
    }   */


    

    ?>
    <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Thank you for your order!</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h3>Uw betaling is succesvol verwerkt</h3>
                        <a href="winkelwagen" class="btn btn-primary">Terug naar de winkelwagen</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h3>Track your order</h3>
                        <p>Your order number is: <?php echo $_SESSION['order_id']; ?></p>
                        <a href="trackOrder.php?order_id=<?php echo $_SESSION['order_id']; ?>" class="btn btn-primary">Track Order</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>