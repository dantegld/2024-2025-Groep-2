<?php
include 'connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];


    $stmt = $mysqli->prepare("SELECT * FROM tblklant WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(50));  
        $expires = time() + 1800;  

        
        $update_stmt = $mysqli->prepare("UPDATE tblklant SET reset_token = ?, reset_expires = ? WHERE email = ?");
        $update_stmt->bind_param("sis", $token, $expires, $email);
        $update_stmt->execute();

 
        $reset_link = "https://myshoes.zoobagogo.com/reset_password?token=" . $token;


        $mail = new PHPMailer(true);

        try {
           
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  
            $mail->SMTPAuth = true;
            $mail->Username = 'contactmyshoes2800@gmail.com';  
            $mail->Password = 'pztvrfzhcksiqzhq';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;  


            $mail->setFrom('myshoes@zoobagogo.com', 'Myshoes');  
            $mail->addAddress($email);  
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = 'Hello, click the following link to reset your password: ' . $reset_link;

            
            $mail->send();
            $message = 'A reset link has been sent to your email. Check your inbox!';
            $message_class = 'success';
        } catch (Exception $e) {
            $message = "Something went wrong while sending the email. Mailer Error: {$mail->ErrorInfo}";
            $message_class = 'error';
        }
    } else {
        $message = "Email address does not exist in our system.";
        $message_class = 'error';
    }

    // Sluit de statement
    $stmt->close();
    $mysqli->close(); // Close the MySQL connection
}


if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Zoek de gebruiker op basis van de token
    $stmt = $mysqli->prepare("SELECT * FROM tblklant WHERE reset_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // De token is geldig, laat de gebruiker het wachtwoord resetten
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['password'], $_POST['confirm_password'])) {
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];

                // Controleer of de wachtwoorden overeenkomen
                if ($password !== $confirm_password) {
                    $message = "Passwords do not match!";
                    $message_class = "error";
                } else {
                    // Hash het nieuwe wachtwoord
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Update het wachtwoord in de database en verwijder de reset-token
                    $stmt = $mysqli->prepare("UPDATE tblklant SET wachtwoord= ?, reset_token = NULL WHERE reset_token = ?");
                    $stmt->bind_param("ss", $hashed_password, $token);

                    if ($stmt->execute()) {
                        // Zet de form op 'niet zichtbaar' omdat het wachtwoord succesvol is gereset
                        $form_visible = false; 
                        $message = "Password successfully reset! You can now log in.";
                        $message_class = "success";
                        sleep(1);
                        header("Location: login");
                    } else {
                        $message = "Er is een fout opgetreden tijdens het resetten van je wachtwoord.";
                        $message_class = "error";
                    }
                }
            } else {
                $message = "Vul alstublieft beide velden in.";
                $message_class = "error";
            }
        }
    } 
    $stmt->close();
    $mysqli->close(); // Close the MySQL connection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset</title>
    <link rel="stylesheet" href="css/form.css">
</head>
<body>

<?php if (!isset($_GET['token'])) { 
    
    ?>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="Email address" required>
        <input type="submit" value="Send reset link">
    </form>
<?php

} else {
    if ($result->num_rows === 0) {
        echo "Invalid reset link!";
    } else {
        ?>
        <form method="POST" action="">
            <input type="password" name="password" placeholder="New password" required>
            <input type="password" name="confirm_password" placeholder="Confirm password" required>
            <input type="submit" value="Reset password">
        </form>
        <?php
    }
}

