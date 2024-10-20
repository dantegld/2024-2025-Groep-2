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
      <title>Website Onderhoud</title>
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
    <div class="onderhoudsPagina">
        <div class="onderhoudsPagina_text">
                <i class="fa fa-cogs fa-5x" aria-hidden="true"></i><br><br>
                <h1>The website is currently under maintenance</h1>
                <p>We are currently maintaining the website.
                Click <a href="index.php">here</a> to try again.</p>
                  <?php
                  include 'connect.php';
                  session_start();
                  include 'functies/functies.php';
                  
      
                  if (isset($_SESSION["klant_id"])) {
                      if($_SESSION["klant_id"]){
                          //echo logout
                            echo '<p><a href="logout.php">Log out</a></p>';
                      }else{
                          echo '<p>You are not logged in. Click <a href="login.php">here</a> to log in anyway</p>';
                      }
                  } else {
                    echo '<p>You are not logged in. Click <a href="login.php">here</a> to log in anyway</p>';
                  }
                  
                  ?>
        </div>
    </div>
    </body>
</html>