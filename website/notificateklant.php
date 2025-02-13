<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Admin Page</title>
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
    include 'connect.php';
    // check if the user is logged in
    session_start();
    include 'functies/functies.php';
    controleerAdmin();
    include 'functies/adminSideMenu.php';
    require 'vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;


    //send email to customer saying order will be arriving soon
    $sql = "SELECT * FROM tblklant WHERE klant_id = '$_SESSION[klant_id]'";
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
            $mail->addBCC($email);
            $mail->Subject = 'Je bestelling komt eraan!';
            $mail->Body    = 'Je bestelling komt eraan!';
            $mail->Body .= "\n\n Jouw bestelling is onderweg en zal binnenkort aankomen. Bedankt voor het winkelen bij My Shoes! Bestelling ID: " . $_GET['verkoop_id'];

            $mail->isHTML(true);    
            $message = 'Er is een notificatie naar je e-mail gestuurd. Controleer je inbox!';
            $message_class = 'success';
            
            
            

        } catch (Exception $e) {
            $message = "Er is iets misgegaan bij het verzenden van de e-mail. Mailer Error: {$mail->ErrorInfo}";
            $message_class = 'error';
            echo $message;
        }
    }

    //echo $message with green background and white text
    echo '<div class="message ' . $message_class . '">' . $message . '</div>';

    

    $mail->send();
    $stmt->close();
    $mysqli->close(); // Close the MySQL connection

header("refresh:3;url=orderStatus.php");