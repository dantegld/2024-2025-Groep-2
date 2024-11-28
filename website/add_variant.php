<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pagina</title>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Admin Pagina</title>
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
session_start();
include 'functies/functies.php';
controleerAdmin();
include 'functies/adminSideMenu.php';
require 'vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
?>
<style>
    option:hover {
        color: #ffffff;
    }
</style>



<?php
if (isset($_POST['add_variatie'])) {
    $artikel_id = $_POST['artikel_id'];
    $kleur_id = $_POST['kleur_id'];
    $image = $_FILES['image']['name'];
    $target = "images/shoes/" . basename($image);

    // Count the number of existing variations for the given artikel_id
    $count_sql = "SELECT * FROM tblvariatie WHERE artikel_id = '$artikel_id'";
    $count_result = $mysqli->query($count_sql);
    $new_variatie_id = $count_result->num_rows + 1;
    // Insert new variation into the database
    $insert_sql = "INSERT INTO tblvariatie (variatie_id, artikel_id, kleur_id, directory) VALUES ('$new_variatie_id', '$artikel_id', '$kleur_id', '$target')";
    if ($mysqli->query($insert_sql) === TRUE) {
        // Upload the image
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $stmt = $mysqli->prepare("INSERT INTO tblstock (artikel_id, variatie_id, stock, schoenmaat) VALUES (?, ?, 0, ?)");

            // Loop to insert 20 rows with increasing schoenmaat
            for ($i = 30; $i < 50; $i++) {
                // Bind parameters to the placeholders
                $stmt->bind_param("iii", $artikel_id, $new_variatie_id, $i);
                // Execute the statement
                $stmt->execute();
            }

            // Close the statement
            $stmt->close();

            $sql = "SELECT * FROM tblvariatie WHERE artikel_id = '$artikel_id'";
            $result1 = $mysqli->query($sql);
            echo $result1->num_rows;
            echo $sql; 
            if($result1->num_rows == 1){
                // Haal alle klanten op met type_id = 2
                $sql = "SELECT * FROM tblklant WHERE type_id = 2";
                $stmt = $mysqli->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                echo $sql;

                // $mail = new PHPMailer(true);

                // while ($row = $result->fetch_assoc()) {
                //     try {
                //         $email = $row['email'];
                //         $mail->isSMTP();
                //         $mail->Host = 'smtp.gmail.com';  
                //         $mail->SMTPAuth = true;
                //         $mail->Username = 'contactmyshoes2800@gmail.com';  
                //         $mail->Password = 'pztvrfzhcksiqzhq';
                //         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                //         $mail->Port = 587;  

                //         $mail->setFrom('contactmyshoes2800@gmail.com', 'My Shoes');  
                //         $mail->addBCC($email);  
                //         $mail->Subject = 'Nieuw Artikel Online';
                //         $mail->Body    = 'Er is een nieuw artikel online, https://myshoes.zoobagogo.com/productpagina?id=' . $artikel_id;

                  
                //         $message = 'Er is een notificatie naar je e-mail gestuurd. Controleer je inbox!';
                //         $message_class = 'success';
                //     } catch (Exception $e) {
                //         $message = "Er is iets misgegaan bij het verzenden van de e-mail. Mailer Error: {$mail->ErrorInfo}";
                //         $message_class = 'error';
                //     }
                // }
                // $mail->send();
            }
        } else {
            echo "Er was een probleem met het uploaden van de afbeelding.";
        }
    } else {
        echo "Er was een probleem met het toevoegen van de variatie.";
    }
}
?>

<div class="adminpage">
    <h2>Add New Variant</h2>
    <?php
    $artikel_id = $_GET['artikel_id'];
    $sql1 = "SELECT artikelnaam FROM tblartikels WHERE artikel_id = '$artikel_id'";
    $result1 = $mysqli->query($sql1);
    $row1 = $result1->fetch_assoc();
    echo "<p>For " . $row1['artikelnaam'] . "</p>";
    ?>
    <form action="add_variant?artikel_id=<?php echo $artikel_id ?> " method="POST" enctype="multipart/form-data">
        <input type="hidden" name="artikel_id" value="<?php echo $artikel_id; ?>">
        <label for="kleur_id">Kleur:</label>
        <select name="kleur_id" required>
            <?php
            $kleur_sql = "SELECT * FROM tblkleur";
            $kleur_result = $mysqli->query($kleur_sql);
            while ($kleur_row = $kleur_result->fetch_assoc()) {
                echo '<option style="background-color:'. $kleur_row['HEX'] . '" value="' . $kleur_row['kleur_id'] . '">' . $kleur_row['kleur'] . '</option>';
            }
            ?>
        </select><br>
        <label for="image">Foto:</label>
        <input type="file" name="image" required><br>
        <input class="btn btn-primary" type="submit" name="add_variatie" value="Add">
    </form>
</div>