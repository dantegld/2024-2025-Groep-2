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
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
.modal-txt{
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}
   </style>
   </head>
   <body>
    <?php
    include 'connect.php';
    session_start();
    include 'functies/functies.php';
    controleerKlant();
    onderhoudsModus();

    ?>

<?php
include 'functies/mySideNav.php';
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
            if(isset($_POST['password'])){
                $password = $_POST['password'];
                $sql = "SELECT * FROM tblklant WHERE klant_id = '$_SESSION[klant_id]'";
                $result = $mysqli->query($sql);
                while ($row = $result->fetch_assoc()) {
                    if (password_verify($password, $row['wachtwoord'])) {
                        $sql = "DELETE FROM tblklant WHERE klant_id = '$_SESSION[klant_id]'";
                        $mysqli->query($sql);
                        header("Location: logout.php?delete=1");
                    } else {
                        echo "<p class='error-msg'>Password is incorrect!</p>";
                    }
                }
            }

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
                        echo' <form action="profile" method="post">
                        <input type="number" name="schoenmaat" value = "' . $vorigeschoenmaat. '" >
                        <input type="submit" name="Change">
                        </form>';
                    }
                }else {
                    $sql1 = "SELECT * FROM tblklant WHERE klant_id = '$_SESSION[klant_id]'";
                    $result1 = $mysqli->query($sql1);
                    while ($row1 = $result1->fetch_assoc()) {
                        if ($row1['schoenmaat'] == null || $row1['schoenmaat'] == 0 || empty($row1['schoenmaat'])) {
                            $vorigeschoenmaat = "Enter your shoe size";
                        } else {
                            $vorigeschoenmaat = $row1['schoenmaat'];
                        }
                    echo' <form action="profile" method="post">
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
                        <p class="address-box">Address: </p>';
                echo '<div class="address-delete"><a href= "adrestoevoegen">Add new address</a></div>';
                echo '</div>';
            } else {
                $klant_id = $_SESSION['klant_id'];
                $sql3 = "SELECT tbladres.adres_id, tbladres.adres, tbladres.postcode_id, tblpostcode.postcode_id, tblpostcode.postcode, tblpostcode.plaats 
                         FROM tbladres 
                         JOIN tblpostcode ON tbladres.postcode_id = tblpostcode.postcode_id 
                         WHERE klant_id = '$klant_id'";
                $result3 = $mysqli->query($sql3);
                
                echo '<br>';
                $adres_count = 1;
                while ($row3 = $result3->fetch_assoc()) {
                    echo '<div class="tabadres">';
                    echo '<p class="address-box">Address ' . $adres_count . ':</p>';
                    echo '<span class = "address-content">' . $row3['adres'] . " " . $row3['postcode'] . " " . $row3['plaats'] . '</span>';
                    echo '<div class="address-delete"><a href="adresverwijderen?adres_id=' . $row3['adres_id'] . '"><i class="fa fa-trash lg"></i></a></div>';
                    echo '</div>';
                    if ($adres_count == $result3->num_rows) {
                        $adres_count++;
                        echo '<br>';
                        echo '<div class="address-add"">';
                        echo '<a href="adrestoevoegen">Add new address</a>';
                        echo '</div>';
                        echo '<br>';
                    }
                    $adres_count++;
                    

                }
            
                if ($adres_count == 1) {
                    echo '<div class="tabadres">';
                    echo '<p>Address 2:</p>';
                    echo '<a href="adrestoevoegen">Add new address</a>';
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
                header("Refresh: 1; url=profile");
            } else {
                echo "<p class='error-msg'>Error updating email address.</p>";
                header("Refresh: 1; url=profile");
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
                header("Refresh: 1; url=profile");
            } else {
                echo "<p class='error-msg'>Error updating phone number.</p>";
                header("Refresh: 1; url=profile");
            }
        }
    }

    // Handle deleting phone number
    if (isset($_POST['delete_telefoonnummer'])) {
        $sql = "UPDATE tblklant SET telefoonnummer = NULL WHERE klant_id = '$_SESSION[klant_id]'";
        if ($mysqli->query($sql)) {
            echo "<p class='success-msg'>Phone number removed!</p>";
            header("Refresh: 1; url=profile");
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
        <form action="profile" method="post">
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
<centre>
    <div class="tab4">
        <a class="btn btn-danger" href="logout.php">Logout</a>
        <a id="deleteProfileBtn" class="btn btn-danger" href="profile">Delete Profile</a>
    </div>
</centre>

<div id="deleteProfileModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-txt">
        <div>
            <p>Are you sure you want to delete your profile? Type your password to continue:</p>
            <form id="deleteProfileForm" method="POST" action="profile.php">
            <input type="hidden" name="klant_id" value="<?php echo $klant_id; ?>">
        </div>
        <div>
            <input class="form-control" type="password" name="password" required>
        </div>
        <br>
        <div>
            <button type="submit" class="btn btn-danger">Delete Profile</button>
        </div>
        </form>
        </div>
    </div>
</div>
<!-- di is delete id -->
<br><br><br>
</div>



   <script>
document.getElementById('deleteProfileBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default action
    document.getElementById('deleteProfileModal').style.display = 'block';
});

document.querySelector('.close').addEventListener('click', function() {
    document.getElementById('deleteProfileModal').style.display = 'none';
});

window.onclick = function(event) {
    if (event.target == document.getElementById('deleteProfileModal')) {
        document.getElementById('deleteProfileModal').style.display = 'none';
    }
};
         function openNav() {
           document.getElementById("mySidenav").style.width = "250px";
         }
         
         function closeNav() {
           document.getElementById("mySidenav").style.width = "0";
         }
      </script>
   </body>
</html>
<?php
$mysqli->close();
?>