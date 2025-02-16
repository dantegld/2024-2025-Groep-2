<?php
// Autoload PHPMailer
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    if ($name && $email && $message) {
        // Maak een nieuwe PHPMailer instantie
        $mail = new PHPMailer(true);

        try {
            // SMTP instellingen
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP-server (bijvoorbeeld Gmail)
            $mail->SMTPAuth = true;
            $mail->Username = 'contactmyshoes2800@gmail.com'; // Vervang met jouw Gmail-adres
            $mail->Password = 'pztvrfzhcksiqzhq'; // Vervang met jouw Gmail-wachtwoord of app-wachtwoord
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Afzender en ontvanger
            $mail->setFrom('contactmyshoes2800@gmail.com', 'MyShoes'); // Gebruik hetzelfde adres als de SMTP-gebruiker
            $mail->addAddress('contactmyshoes2800@gmail.com', 'Myshoes'); // Doeladres

            // E-mail inhoud
            $mail->isHTML(false);
            $mail->Subject = 'Nieuw contactbericht';
            $mail->Body = "Naam: $name\nE-mail: $email\n\nBericht:\n$message";

            // Verstuur e-mail
            $mail->send();
            
            echo "<script>alert('Bericht succesvol verzonden! Je ontvangt zo snel mogelijk een antwoord van ons team.'); window.location.href = 'contact.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Bericht kon niet worden verzonden. Mailer Error: {$mail->ErrorInfo}'); window.location.href = 'contact';</script>";
        }
    } else {
        echo "<script>alert('Alle velden zijn verplicht en het e-mailadres moet geldig zijn.'); window.location.href = 'contact';</script>";
    }
} else {
    echo "<script>alert('Ongeldige aanvraag.'); window.location.href = 'contact';</script>";
}
?>
