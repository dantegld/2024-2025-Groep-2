<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Myshoes</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
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
    include 'functies/functies.php';
    session_start();
    ?>

                    <div id="mySidenav" class="sidenav">
                     <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                     <a href="index.php">Home</a>
                     <a href="profile.php">My Profile</a>
                     <?php
                     if ($_SESSION["admin"]){
                        echo '<a href="admin.php">Admin Pagina</a>';
                     }
                     ?>
                  </div>
                  <span class="toggle_icon1" onclick="openNav()"><img  width="44px" src="images/icon/Hamburger_icon.svg.png"></span>


                <div class="profilepage"><br><br>
                <?php
        $sql = "SELECT * FROM tblklant WHERE klant_id = '$_SESSION[klant_id]'";
        $result = $mysqli->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo '<h2 class= "title2">Welkom, ' . $row['klantnaam'] . '!</h2>';
        }
        ?>
        <div class="tab">
            <p>Schoenmaat:</p> 
            <?php

                if(isset($_POST['schoenmaat'])){
                    $schoenmaat = $_POST['schoenmaat'];
                    $sql2 = "UPDATE tblklant SET schoenmaat = '$schoenmaat' WHERE klant_id = '$_SESSION[klant_id]'";
                    $mysqli->query($sql2);
                    $sql1 = "SELECT * FROM tblklant WHERE klant_id = '$_SESSION[klant_id]'";
                    $result1 = $mysqli->query($sql1);
                    while ($row1 = $result1->fetch_assoc()) {
                        if ($row1['schoenmaat'] == null) {
                            $vorigeschoenmaat = "Voer uw schoenmaat in";
                        } else {
                            $vorigeschoenmaat = $row1['schoenmaat'];
                        }
                        echo' <form action="profile.php" method="post">
                        <input type="number" name="schoenmaat" placeholder = "' . $vorigeschoenmaat. '" >
                        <input type="submit" name="Pas aan">
                        </form>';
                    }
                }else {
                    $sql1 = "SELECT * FROM tblklant WHERE klant_id = '$_SESSION[klant_id]'";
                    $result1 = $mysqli->query($sql1);
                    while ($row1 = $result1->fetch_assoc()) {
                        if ($row1['schoenmaat'] == null) {
                            $vorigeschoenmaat = "Voer uw schoenmaat in";
                        } else {
                            $vorigeschoenmaat = $row1['schoenmaat'];
                        }
                    echo' <form action="profile.php" method="post">
                    <input type="number" name="schoenmaat" placeholder = "' . $vorigeschoenmaat. '" >
                    <input type="submit" name="Pas aan">
                    </form>';
                }
            }

            
            
            ?>
        </div>
        <div class="tab1">
            <?php
            $sql = "SELECT * FROM tbladres WHERE klant_id = '$_SESSION[klant_id]'";
            $result = $mysqli->query($sql);
            ?>
            <div class="tabadres">
        <p>Adres 1:</p>
        <?php
        if ($result->num_rows == 0) {

                echo '<a href= "adrestoevoegen.php">Voeg uw adres toe</a>';
            
        } else {
            $klant_id = $_SESSION['klant_id'];
            $sql3 = "SELECT tbladres.adres, tbladres.postcode_id, tblpostcode.postcode_id,tblpostcode.postcode,tblpostcode.plaats 
            FROM tbladres,tblpostcode WHERE klant_id = '$klant_id' and adres_id = 1";
            $result3 = $mysqli->query($sql3);
            while ($row3 = $result3->fetch_assoc()) {
                echo $row3['adres'];
                echo " ";
                echo $row3['postcode'];
                echo " ";
                echo $row3['plaats'];
            }
        }
        ?>
</div><br>
<div class="tabadres">
        <p>Adres 2:</p>
        <?php
        if ($result->num_rows == 1 || $result->num_rows == 0) {

                echo '<a href= "adrestoevoegen.php">Voeg uw adres toe</a>';

        } else {
            $klant_id = $_SESSION['klant_id'];
            $sql3 = "SELECT tbladres.adres, tbladres.postcode_id, tblpostcode.postcode_id,tblpostcode.postcode,tblpostcode.plaats 
            FROM tbladres,tblpostcode WHERE klant_id = '$klant_id' and adres_id = 2";
            $result3 = $mysqli->query($sql3);
            while ($row3 = $result3->fetch_assoc()) {
                echo $row3['adres'];
                echo " ";
                echo $row3['postcode'];
                echo " ";
                echo $row3['plaats'];
            }
        }
        ?>
</div><br>
<div class="tabadres">
                
        <p>Adres 3:</p>
        <?php
        if ($result->num_rows == 1|| $result->num_rows == 2 || $result->num_rows == 0) {

                echo '<a href= "adrestoevoegen.php">Voeg uw adres toe</a>';
            
        } else {
            $klant_id = $_SESSION['klant_id'];
            $sql3 = "SELECT tbladres.adres, tbladres.postcode_id, tblpostcode.postcode_id,tblpostcode.postcode,tblpostcode.plaats 
            FROM tbladres,tblpostcode WHERE klant_id = '$klant_id' and adres_id = 2";
            $result3 = $mysqli->query($sql3);
            while ($row3 = $result3->fetch_assoc()) {
                echo $row3['adres'];
                echo " ";
                echo $row3['postcode'];
                echo " ";
                echo $row3['plaats'];
            }
        }
        ?>

        
        </div>
                </div><br> 
                <div class="tab3">
    <?php
    // Fetch existing user information
    $sql = "SELECT email, telefoonnummer FROM tblklant WHERE klant_id = '$_SESSION[klant_id]'";
    $result = $mysqli->query($sql);

    // Check if the query was successful and returned a row
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        // Handle the case where no user is found or query fails
        echo "<p class='error-msg'>Fout: Gebruiker niet gevonden of databasefout!</p>";
        $user = [
            'email' => '', 
            'telefoonnummer' => ''
        ]; // Default empty values to avoid undefined index errors
    }

    // Handle updating email address
    if (isset($_POST['update_email'])) {
        $new_email = $_POST['email'] ?? null;
        if ($new_email) {
            $sql = "UPDATE tblklant SET email = '$new_email' WHERE klant_id = '$_SESSION[klant_id]'";
            if ($mysqli->query($sql)) {
                echo "<p class='success-msg'>E-mailadres bijgewerkt!</p>";
                header("Refresh: 1; url=profile.php");
            } else {
                echo "<p class='error-msg'>Fout bij het bijwerken van het e-mailadres.</p>";
                header("Refresh: 1; url=profile.php");
            }
        }
    }

    // Handle updating phone number
    if (isset($_POST['update_telefoonnummer'])) {
        $new_phone_number = $_POST['telefoonnummer'] ?? null;
        if ($new_phone_number !== null && trim($new_phone_number) === '') {
            // Phone number is empty, but not using delete
            echo "<p class='error-msg'>U heeft het telefoonnummer leeggelaten. Als u het wilt verwijderen, gebruik de knop 'Verwijder Telefoonnummer'.</p>";
        } elseif ($new_phone_number) {
            // Update the phone number
            $sql = "UPDATE tblklant SET telefoonnummer = '$new_phone_number' WHERE klant_id = '$_SESSION[klant_id]'";
            if ($mysqli->query($sql)) {
                echo "<p class='success-msg'>Telefoonnummer bijgewerkt!</p>";
                header("Refresh: 1; url=profile.php");
            } else {
                echo "<p class='error-msg'>Fout bij het bijwerken van het telefoonnummer.</p>";
                header("Refresh: 1; url=profile.php");
            }
        }
    }

    // Handle deleting phone number
    if (isset($_POST['delete_telefoonnummer'])) {
        $sql = "UPDATE tblklant SET telefoonnummer = NULL WHERE klant_id = '$_SESSION[klant_id]'";
        if ($mysqli->query($sql)) {
            echo "<p class='success-msg'>Telefoonnummer verwijderd!</p>";
            header("Refresh: 1; url=profile.php");
        } else {
            echo "<p class='error-msg'>Fout bij het verwijderen van het telefoonnummer.</p>";
        }
    }

    // Handle adding email and phone number
    if (isset($_POST['add_fields'])) {
        $new_email = $_POST['email'] ?? null;
        $new_phone_number = $_POST['telefoonnummer'] ?? null;

        if ($new_email) {
            $sql = "UPDATE tblklant SET email = '$new_email' WHERE klant_id = '$_SESSION[klant_id]'";
            $mysqli->query($sql);
        }
        if ($new_phone_number) {
            $sql = "UPDATE tblklant SET telefoonnummer = '$new_phone_number' WHERE klant_id = '$_SESSION[klant_id]'";
            $mysqli->query($sql);
        }
        echo "<p class='success-msg'>Velden toegevoegd!</p>";
    }
    ?>

    <!-- Form for Updating/Adding Information -->
    <div class="tab3">
        <form action="profile.php" method="post">
            <label for="email">E-mailadres:</label><br>
            <input type="email" name="email" placeholder="Voer uw e-mailadres in" value="<?= isset($user['email']) ? $user['email'] : '' ?>" class="form-control"><br><br>
            <input type="submit" name="update_email" value="Update E-mailadres" class="btn btn-primary"> <br><br>
            <br>

            <label for="telefoonnummer">Telefoonnummer:</label><br>
            <input type="text" name="telefoonnummer" placeholder="Voer uw telefoonnummer in" value="<?= isset($user['telefoonnummer']) ? $user['telefoonnummer'] : '' ?>" class="form-control"><br><br>
            <input type="submit" name="update_telefoonnummer" value="Update Telefoonnummer" class="btn btn-primary">
            <input type="submit" name="delete_telefoonnummer" value="Verwijder Telefoonnummer" class="btn btn-danger">
        </form>
    </div>
</div>


                </div>



   <script>
         function openNav() {
           document.getElementById("mySidenav").style.width = "250px";
         }
         
         function closeNav() {
           document.getElementById("mySidenav").style.width = "0";
         }
      </script>
   </body>
</html>