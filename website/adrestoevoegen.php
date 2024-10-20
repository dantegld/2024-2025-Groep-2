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
                  <h2 class="title3">Add new address</h2>
                    <?php
                    $klant_id = $_SESSION['klant_id'];
                    $sql = "SELECT * FROM tbladres WHERE klant_id = '$klant_id'";
                    $result = $mysqli->query($sql);
                    if ($result->num_rows == 0) {
                        $adres_id = 1;
                    }else if ($result->num_rows == 1) {
                        $adres_id = 2;
                    }else if ($result->num_rows == 2) {
                        $adres_id = 3;
                    }else if ($result->num_rows == 3) {
                        Header("Location: profile.php");
                    }
                    if(isset($_POST['adresbtn'])){
                        $klant_id = $_SESSION['klant_id'];
                        $postcode = $_POST['postcode'];
                        $sql1 = "SELECT * FROM tblpostcode WHERE postcode = '$postcode'";
                        $result1 = $mysqli->query($sql1);
                        while ($row = $result1->fetch_assoc()) {
                            $postcode_id = $row['postcode_id'];
                        }
                        $adres = $_POST['adres'];
                        $sql2 = "INSERT INTO tbladres (adres_id, klant_id, adres, postcode_id) VALUES ('$adres_id', '$klant_id', '$adres', '$postcode_id')";
                        $mysqli->query($sql2);
                        Header("Location: profile.php");
                    }else {
                        //php form
                        ?>
                        <div class='loginForm'>
                        <?php
                                            echo' <form action="adrestoevoegen.php" method="post">
                                            <label>Address:</label><br>
                                            <input type="text"  class="form-control" name="adres" id="adres" required><br>
                                            <label>City code:</label><br>
                                            <input type="text"  class="form-control" name="postcode" id="postcode" required><br><br>
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