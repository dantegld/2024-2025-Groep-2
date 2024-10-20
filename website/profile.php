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
   <style>
     h2{
       text-align: center;
       margin-top: 20px;
     }
   </style>
   </head>
   <body>
    <?php
    include 'connect.php';
    include 'functies/functies.php';
    session_start();
    ?>

<?php
include 'functies/MySideNav.php';
?>
<span class="toggle_icon1" onclick="openNav()"><img  width="44px" src="images/icon/Hamburger_icon.svg.png"></span>


        <div class="profilepage"><br><br>
        <?php
        $sql = "SELECT * FROM tblklant WHERE klant_id = '$_SESSION[klant_id]'";
        $result = $mysqli->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo '<h2 class= "title2">Welcome, ' . $row['klantnaam'] . '!</h2>';
        }
        ?>
        <div class="tab">
            <p>Shoe size:</p> 
            <?php

                if(isset($_POST['schoenmaat'])){
                    $schoenmaat = $_POST['schoenmaat'];
                    $sql2 = "UPDATE tblklant SET schoenmaat = '$schoenmaat' WHERE klant_id = '$_SESSION[klant_id]'";
                    $mysqli->query($sql2);
                    $sql1 = "SELECT * FROM tblklant WHERE klant_id = '$_SESSION[klant_id]'";
                    $result1 = $mysqli->query($sql1);
                    while ($row1 = $result1->fetch_assoc()) {
                        if ($row1['schoenmaat'] == null) {
                            $vorigeschoenmaat = "Enter your shoe size";
                        } else {
                            $vorigeschoenmaat = $row1['schoenmaat'];
                        }
                        echo' <form action="profile.php" method="post">
                        <input type="number" name="schoenmaat" value = "' . $vorigeschoenmaat. '" >
                        <input type="submit" name="Change">
                        </form>';
                    }
                }else {
                    $sql1 = "SELECT * FROM tblklant WHERE klant_id = '$_SESSION[klant_id]'";
                    $result1 = $mysqli->query($sql1);
                    while ($row1 = $result1->fetch_assoc()) {
                        if ($row1['schoenmaat'] == null) {
                            $vorigeschoenmaat = "Enter your shoe size";
                        } else {
                            $vorigeschoenmaat = $row1['schoenmaat'];
                        }
                    echo' <form action="profile.php" method="post">
                    <input type="number" name="schoenmaat" value = "' . $vorigeschoenmaat. '" >
                    <input type="submit" name="Change">
                    </form>';
                }
            }

            
            
            ?>
        </div>
        <div class="tab1">
            <?php
            $klant_id = $_SESSION['klant_id'];
            $sql = "SELECT * FROM tbladres WHERE klant_id = '" . $klant_id . "'";
            $result = $mysqli->query($sql);

            if ($result->num_rows == 0) {
                echo '  <div class="tabadres">
                        <p>Address: </p>';
                echo '<a href= "adrestoevoegen.php">Add new address</a>';
                echo '</div>';
            } else {
                $klant_id = $_SESSION['klant_id'];
                $sql3 = "SELECT tbladres.adres, tbladres.postcode_id, tblpostcode.postcode_id, tblpostcode.postcode, tblpostcode.plaats 
                         FROM tbladres 
                         JOIN tblpostcode ON tbladres.postcode_id = tblpostcode.postcode_id 
                         WHERE klant_id = '$klant_id'";
                $result3 = $mysqli->query($sql3);
                
            
                $adres_count = 1;
                while ($row3 = $result3->fetch_assoc()) {
                    echo '<div class="tabadres">';
                    echo '<p>Address ' . $adres_count . ':</p>';
                    echo $row3['adres'] . " " . $row3['postcode'] . " " . $row3['plaats'];
                    echo '</div>';
                    if ($adres_count == $result3->num_rows) {
                        $adres_count++;
                        echo '<div class="tabadres">';
                        echo '<p>Adres ' . $adres_count .':</p>';
                        echo '<a href="adrestoevoegen.php">Add new address</a>';
                        echo '</div>';
                    }
                    $adres_count++;
                    

                }
            
                if ($adres_count == 1) {
                    echo '<div class="tabadres">';
                    echo '<p>Address 2:</p>';
                    echo '<a href="adrestoevoegen.php">Add new address</a>';
                    echo '</div>';
                }
            }
            ?>
        </div>


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
                echo "<p class='success-msg'>Email address updated!</p>";
                header("Refresh: 1; url=profile.php");
            } else {
                echo "<p class='error-msg'>Error updating email address.</p>";
                header("Refresh: 1; url=profile.php");
            }
        }
    }

    // Handle updating phone number
    if (isset($_POST['update_telefoonnummer'])) {
        $new_phone_number = $_POST['telefoonnummer'] ?? null;
        if ($new_phone_number !== null && trim($new_phone_number) === '') {
            // Phone number is empty, but not using delete
            echo "<p class='error-msg'>You have left the phone number blank. If you want to remove it, use the 'Remove Phone Number' button'.</p>";
        } elseif ($new_phone_number) {
            // Update the phone number
            $sql = "UPDATE tblklant SET telefoonnummer = '$new_phone_number' WHERE klant_id = '$_SESSION[klant_id]'";
            if ($mysqli->query($sql)) {
                echo "<p class='success-msg'>Phone number updated!</p>";
                header("Refresh: 1; url=profile.php");
            } else {
                echo "<p class='error-msg'>Error updating phone number.</p>";
                header("Refresh: 1; url=profile.php");
            }
        }
    }

    // Handle deleting phone number
    if (isset($_POST['delete_telefoonnummer'])) {
        $sql = "UPDATE tblklant SET telefoonnummer = NULL WHERE klant_id = '$_SESSION[klant_id]'";
        if ($mysqli->query($sql)) {
            echo "<p class='success-msg'>Phone number removed!</p>";
            header("Refresh: 1; url=profile.php");
        } else {
            echo "<p class='error-msg'>Error while deleting phone number.</p>";
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
        echo "<p class='success-msg'>Fields added!</p>";
    }
    ?>

    <!-- Form for Updating/Adding Information -->
    <div class="tab5">
        <form action="profile.php" method="post">
            <label for="email">Email address:</label><br>
            <input type="email" name="email" placeholder="Enter your email address" value="<?= isset($user['email']) ? $user['email'] : '' ?>" class="form-control"><br><br>
            <input type="submit" name="update_email" value="Update Email address" class="btn btn-primary"> <br><br>
            <br>

            <label for="telefoonnummer">Phone number:</label><br>
            <input type="text" name="telefoonnummer" placeholder="Enter your phone number" value="<?= isset($user['telefoonnummer']) ? $user['telefoonnummer'] : '' ?>" class="form-control"><br><br>
            <input type="submit" name="update_telefoonnummer" value="Update Phone number" class="btn btn-primary">
            <input type="submit" name="delete_telefoonnummer" value="Delete Phone number" class="btn btn-danger">
        </form>
    </div>
</div>
<div class="tab4"><a class="btn btn-danger" href="logout.php">Logout</a></div><br><br><br>
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