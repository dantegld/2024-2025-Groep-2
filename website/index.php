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
         onderhoudsModus();
         //initaliseerd de klant variabele zodat er verder geen errors komen voor bezoekers die niet zijn ingelogd.
         if (!(isset($_SESSION["klant"]))) {
            $_SESSION["klant"] = false;
         }
         if (!(isset($_SESSION["admin"]))) {
            $_SESSION["admin"] = false;
         }
      ?>




      <!-- banner bg main start -->
      <div class="banner_bg_main">
         <!-- header top section start -->
         <!-- header top section start -->
         <!-- logo section start -->
         <div class="logo_section">
            <div class="container">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="logo"><a href="index.php"><img src="images/icon/logo.svg"></a></div>
                  </div>
               </div>
            </div>
         </div>
         <!-- logo section end -->
         <!-- header section start -->
         <div class="header_section">
            <div class="container">
               <div class="containt_main">
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
                  <span class="toggle_icon" onclick="openNav()"><img src="images/icon/toggle-icon.png"></span>
                 
                  <div class="main">
                     <!-- Another variation with a button -->
                     <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search the store">
                        <div class="input-group-append">
                           <button class="btn btn-secondary" type="button" style="background-color: #f26522; border-color:#f26522 ">
                           <i class="fa fa-search"></i>
                           </button>
                        </div>
                     </div>
                  </div>
                  <div class="header_box">
                     <div class="login_menu">
                        <ul>
                           <li><a href="#">
                              <i class="fa fa-heart" aria-hidden="true"></i>
                              <span class="padding_5">Wishlist</span></a>
                           </li>
                           <li><a href="#">
                              <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                              <span class="padding_5">Cart</span></a>
                           </li>
                           <?php
                           //Als de klant is ingelogd, laat de knop "My Profile" zien, anders laat de knop "Log-In" zien
                           if ($_SESSION["klant"]){
                              echo '<li><a href="myprofile.php">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span class="padding_5">My Profile</span></a>
                                    </li>';
                           }else{
                              echo '<li><a href="login.php">
                              <i class="fa fa-user" aria-hidden="true"></i>
                              <span class="padding_5">Log-In</span></a>
                           </li>';
                           }
                           ?>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- header section end -->
         <!-- banner section start -->
         <div class="banner_section layout_padding">
            <div class="container">
                              <h1 class="banner_taital">Get Started <br>Your favorite store</h1>
                           </div>
                        </div>
                     </div>
                  </div>   
               </div>
            </div>
         </div>
         <!-- banner section end -->
      </div>
      <!-- banner bg main end -->
      <!-- fashion section start -->
      <div class="fashion_section">
   <div id="main_slider" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
         <div class="carousel-item active">
            <div class="container">
               <br>
               <h1 class="fashion_taital">Shoes</h1>
               <div class="fashion_section_2">
                  <div class="row">
                     <?php
                     include 'connect.php';

                     // Check connection
                     if (!$mysqli) {
                        die("Connection failed: " . mysqli_connect_error());
                     }

                     // Fetch shoe data
                     $sql = "SELECT artikel_id,artikelnaam, prijs, directory FROM tblartikels";
                     $result = mysqli_query($mysqli, $sql);

                     if (mysqli_num_rows($result) > 0) {
                        // Output data of each row
                        //WISHLIST BUTTON NOT WORKING
                        while($row = mysqli_fetch_assoc($result)) {
                           echo '<div class="col-lg-4 col-sm-4">';
                           echo '   <div class="box_main">';
                           echo '      <h4 class="shirt_text">' . htmlspecialchars($row["artikelnaam"]) . '</h4>';
                           echo '      <p class="price_text">Price  <span style="color: #262626;">$ ' . htmlspecialchars($row["prijs"]) . '</span></p>';
                           echo '      <div class="tshirt_img"><img src="' . htmlspecialchars($row["directory"]) . '"></div>';
                           echo '      <div class="btn_main">';
                           echo '         <div class="buy_bt"><a href="cartCalc.php?id='.$row['artikel_id'].'">Add to cart</a></div>';
                           echo '         <div class="seemore_bt"><i class="fa fa-heart" aria-hidden="true"></i><a href="#">  Wishlist</a></div>';
                           echo '         <div class="seemore_bt"><a href="#">See More</a></div>';
                           echo '      </div>';
                           echo '   </div>';
                           echo '</div>';
                        }
                     } else {
                        echo "0 results";
                     }
      
                     mysqli_close($mysqli);
                     ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
            <!--
            <div class="loader_main"></div>
               <div class="loader"></div>
            </div>
            -->
         </div>
      </div>
      <!-- jewellery  section end -->
      <!-- footer section start -->
      <div class="footer_section layout_padding">
         <div class="container">
            <div class="footer_logo"><a href="index.php"><img src="images/icon/logo.svg"></a></div>

            <div class="location_main">Help Line  Number : <a href="#">+1 1800 1200 1200</a></div>
         </div>
      </div>
      <!-- footer section end -->
      <!-- copyright section start -->
      <div class="copyright_section">
         <div class="container">
            <p class="copyright_text">© 2024 Myshoes All Rights Reserved.</p>
         </div>
      </div>
      <!-- copyright section end -->
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