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
    session_start();
    include 'functies/functies.php';
    controleerKlant();
    onderhoudsModus();

    ?>

               <div style="position: absolute; top: 10px; left: 10px;">
                  <a href="profile"><img src="images/shoes/goback.png" style="width: 50px; height: auto;"></a>
               </div>
                  <h2 class="title3">Add new address</h2>
                    <?php
                    $klant_id = $_SESSION['klant_id'];
                    $sql = "SELECT * FROM tbladres WHERE klant_id = '$klant_id'";
                    $result = $mysqli->query($sql);
                    $adres_id = $result->num_rows + 1;
                    if(isset($_POST['adresbtn'])){
                        $klant_id = $_SESSION['klant_id'];
                        $postcode = $_POST['postcode'];
                        $sql1 = "SELECT * FROM tblpostcode WHERE postcode = '$postcode'";
                        $result1 = $mysqli->query($sql1);
                        while ($row = $result1->fetch_assoc()) {
                            $postcode_id = $row['postcode_id'];
                        }
                        $adres = $_POST['adres'];
                        $nation = $_POST['nation'];
                        $sql2 = "INSERT INTO tbladres (adres_id, klant_id, adres, postcode_id, landID) VALUES ('$adres_id', '$klant_id', '$adres', '$postcode_id','$nation')";
                        $mysqli->query($sql2);
                        Header("Location: profile");
                        $mysqli->close(); // Close the MySQL connection
                    } else {
                        //php form  
                        ?>
                        <div class='loginForm'>
                        <?php
                                            echo' <form action="adrestoevoegen" method="post">
                                            <label>Address:</label><br>
                                            <input type="text"  class="form-control" name="adres" id="adres" required><br>
                                            <label>City code:</label><br>
                                            <input type="text"  class="form-control" name="postcode" id="postcode" required><br>
                                          <label>Nation:</label><br>
                                            <select class="form-control" name="nation" id="nation" required>';
                                              
                                              $sql3 = "SELECT * FROM tblLand";
                                              $result3 = $mysqli->query($sql3);
                                              while ($row = $result3->fetch_assoc()) {
                                                 echo '<option value="' . $row['landID'] . '">' . $row['landNaam'] . '</option>';
                                              }
                                          
                                           echo '</select><br>
                                            <input class="btn btn-primary" type="submit" value = "Add new adress" name="adresbtn"><br>
                                            </form><br>';

                    }
                    
                    ?>
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