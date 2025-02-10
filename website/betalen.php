<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afrekenen</title>
    <!-- CSS en andere resources -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
</head>

<body>
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

    // Verwijder de komma's en zet de waarde om naar een float
    $totaal = (float) str_replace(',', '', $totaal);

    // Als de betaling is gedaan
    if (isset($_POST['betalen'])) {
        $payment_method = $_POST['payment_method'];
        $payment_method = strtolower($payment_method);

        // Haal het persoonlijke bericht op
        $personal_message = isset($_POST['personal_message']) ? trim($_POST['personal_message']) : null;

        if ($payment_method == 'paypal') {
            processPayPalPayment($totaal);
        } else if ($payment_method == 'stripe') {
            processStripePayment($totaal);
        } else {
            echo "Invalid payment method selected.";
            die;
        }

        // Neem email van de klant
        $sql = "SELECT email FROM tblklant WHERE klant_id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $_SESSION['klant_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $email = $row['email'];
        $stmt->close();

        // Sla de bestelling op in de database inclusief het persoonlijke bericht
        $sql = "INSERT INTO tblorders (klant_id, totaalbedrag, persoonlijke_bericht) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ids", $_SESSION['klant_id'], $totaal, $personal_message);
        $stmt->execute();
        $stmt->close();

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
        <form action='' method='post'>
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

            // Persoonlijk bericht toevoegen
            echo "
            <br>
            <h4>Add a personal message to your order:</h4>
            <textarea name='personal_message' rows='4' cols='50' placeholder='Write your personal message here...'></textarea>
            <br><br>
            <input type='submit' value='Pay now' name='betalen' class='btn btn-primary'>
            ";
        }
        echo "</div></form>";
        $result->close();
        $mysqli->close(); // Close the MySQL connection
    }

    echo ' </div>
    </div>';
    ?>
</body>

</html>
