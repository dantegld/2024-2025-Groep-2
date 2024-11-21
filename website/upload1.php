<?php
include 'connect.php';
include 'functies/functies.php';
require 'vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST["submit"])){
    $naam = $_POST['naam'];
    $prijs = $_POST['prijs'];

    // Voeg het artikel toe aan de database
    $sql = "INSERT INTO tblartikels (artikelnaam, prijs) VALUES (?, ?)"; 
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $naam, $prijs);
    $stmt->execute();
    $artikel_id = $stmt->insert_id; // Haal het ID van het nieuw toegevoegde artikel op
    $stmt->close();

    // Haal alle klanten op met type_id = 2
    $sql = "SELECT * FROM tblklant WHERE type_id = 2";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $mail = new PHPMailer(true);

    while ($row = $result->fetch_assoc()) {
        try {
            $email = $row['email'];
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  
            $mail->SMTPAuth = true;
            $mail->Username = 'contactmyshoes2800@gmail.com';  
            $mail->Password = 'pztvrfzhcksiqzhq';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;  

            $mail->setFrom('contactmyshoes2800@gmail.com', 'My Shoes');  
            $mail->addAddress($email);  
            $mail->Subject = 'Nieuw Artikel Online';
            $mail->Body    = 'Er is een nieuw artikel online, https://myshoes.zoobagogo.com/productpagina?id=' . $artikel_id;

            $mail->send();
            $message = 'Er is een notificatie naar je e-mail gestuurd. Controleer je inbox!';
            $message_class = 'success';
        } catch (Exception $e) {
            $message = "Er is iets misgegaan bij het verzenden van de e-mail. Mailer Error: {$mail->ErrorInfo}";
            $message_class = 'error';
        }
    }

    header("Location: aanpassen");
}
?>