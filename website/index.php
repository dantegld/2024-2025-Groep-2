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
         session_start();
         include 'functies/functies.php';
         include 'connect.php';
         
         //initaliseerd de klant variabele zodat er verder geen errors komen voor bezoekers die niet zijn ingelogd.
         if(isset($_SESSION['klant_id'])){
         $sql = "SELECT k.type_id ,t.type_id,t.type FROM tblklant k,tbltypes t WHERE klant_id = ?  and k.type_id = t.type_id";
         $stmt = $mysqli->prepare($sql);
         $stmt->bind_param("i", $_SESSION['klant_id']);
         $stmt->execute();
         $result = $stmt->get_result();
         $row = $result->fetch_assoc();
         $_SESSION['type'] = $row['type'];
         }else{
         $_SESSION['type'] = "guest";
         }
         onderhoudsModus();
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
                     <div class="logo"><a href="index"><img src="images/icon/logo.svg"></a></div>
                  </div>
               </div>
            </div>
         </div>
         <!-- logo section end -->
         <!-- header section start -->
         <div class="header_section">
            <div class="container">
               <div class="containt_main">
                  <?php
                  include 'functies/mySideNav.php';
                  ?>
                  <span class="toggle_icon" onclick="openNav()"><img src="images/icon/toggle-icon.png"></span>
                 
                  <div class="main">
                     <!-- Another variation with a button -->
                     <form class="input-group" method="GET" action="index#shoes">
                     <?php if(isset($_GET['q'])){
                              $q = $_GET['q'];
                           ?>
                        <input type="text" class="form-control" name="q" placeholder="Search the store" value="<?php echo "$q";?>">
                        <?php }else{ ?>
                        <input type="text" class="form-control" name="q" placeholder="Search the store">
                        <?php } ?>
                        <span class="input-group-append">

                           <button type="submit" class="btn btn-secondary" style="background-color: #f26522; border-color:#f26522">
                              <i class="fa fa-search"></i>
                           </button>
                           <span id="filterBtn" class="btn btn-secondary" style="background-color: #f26522; border-color:#f26522;margin-left:1px;"><i class="fa fa-filter"></i></span>
                           <span id="sortBtn" class="btn btn-secondary dropdown-toggle" style="background-color: #f26522; border-color:#f26522;margin-left:1px;" data-toggle="dropdown"><i class="fa fa-sort"></i>
                           <div class="dropdown-menu" id="sortOptionsContainer" style="position: absolute;">
                              <?php if(isset($_GET['min']) && isset($_GET['q'])){
                                 $q = $_GET['q'];
                                 $min = $_GET['min'];
                                 $max = $_GET['max'];
                              ?>
                              <a class="dropdown-item" href="index?q=<?php echo"$q";?>&min=<?php echo"$min";?>&max=<?php echo"$max";?>&s=trnd#shoes"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
                              <a class="dropdown-item" href="index?q=<?php echo"$q";?>&min=<?php echo"$min";?>&max=<?php echo"$max";?>&s=abc#shoes">ABC</a>
                              <a class="dropdown-item" href="index?q=<?php echo"$q";?>&min=<?php echo"$min";?>&max=<?php echo"$max";?>&s=pru#shoes">&euro;&uarr;</a>
                              <a class="dropdown-item" href="index?q=<?php echo"$q";?>&min=<?php echo"$min";?>&max=<?php echo"$max";?>&s=prd#shoes">&euro;&darr;</a>
                              <?php }else if(isset($_GET['q'])){
                                 $q = $_GET['q'];
                              ?>
                              <a class="dropdown-item" href="index?q=<?php echo"$q";?>&s=trnd#shoes"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
                              <a class="dropdown-item" href="index?q=<?php echo"$q";?>&s=abc#shoes">ABC</a>
                              <a class="dropdown-item" href="index?q=<?php echo"$q";?>&s=pru#shoes">&euro;&uarr;</a>
                              <a class="dropdown-item" href="index?q=<?php echo"$q";?>&s=prd#shoes">&euro;&darr;</a>
                              <?php }else if(isset($_GET['min'])){
                                 $min = $_GET['min'];
                                 $max = $_GET['max'];
                              ?>
                              <a class="dropdown-item" href="index?min=<?php echo"$min";?>&max=<?php echo"$max";?>&s=trnd#shoes"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
                              <a class="dropdown-item" href="index?min=<?php echo"$min";?>&max=<?php echo"$max";?>&s=abc#shoes">ABC</a>
                              <a class="dropdown-item" href="index?min=<?php echo"$min";?>&max=<?php echo"$max";?>&s=pru#shoes">&euro;&uarr;</a>
                              <a class="dropdown-item" href="index?min=<?php echo"$min";?>&max=<?php echo"$max";?>&s=prd#shoes">&euro;&darr;</a>
                              <?php }else{ ?>
                              <a class="dropdown-item" href="index?s=trnd#shoes"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
                              <a class="dropdown-item" href="index?s=abc#shoes">ABC</a>
                              <a class="dropdown-item" href="index?s=pru#shoes">&euro;&uarr;</a>
                              <a class="dropdown-item" href="index?s=prd#shoes">&euro;&darr;</a>
                              <?php } ?>
                           </div>
                           </span>
                        </span>
                     </form>
                           <?php
                           $sqlmax = "SELECT MAX(prijs) as maxprijs FROM tblartikels";
                           $resultmax = mysqli_query($mysqli, $sqlmax);
                           $rowmax = mysqli_fetch_assoc($resultmax);
                           $maxprijs = $rowmax['maxprijs'];
                           $maxprijsfinal = $maxprijs;

                           $sqlmin = "SELECT MIN(prijs) as minprijs FROM tblartikels";
                           $resultmin = mysqli_query($mysqli, $sqlmin);
                           $rowmin = mysqli_fetch_assoc($resultmin);
                           $minprijs = $rowmin['minprijs'];

                           if(isset($_GET['q'])){
                              $q = $_GET['q'];
                              $sqlmin = "SELECT MIN(prijs) as minprijs FROM tblartikels WHERE artikelnaam LIKE '%$q%'";
                              $resultmin = mysqli_query($mysqli, $sqlmin);
                              $rowmin = mysqli_fetch_assoc($resultmin);
                              $minprijs = $rowmin['minprijs'];

                              $sqlmax = "SELECT MAX(prijs) as maxprijs FROM tblartikels WHERE artikelnaam LIKE '%$q%'";
                              $resultmax = mysqli_query($mysqli, $sqlmax);
                              $rowmax = mysqli_fetch_assoc($resultmax);
                              $maxprijs = $rowmax['maxprijs'];
                              $maxprijsfinal = $maxprijs;

                              if(isset($_GET['min'])){
                                 $minprijs = $_GET['min'];
                                 $maxprijs = $_GET['max'];
                           }
                        }

                        if(isset($_GET['min'])){
                           $minprijs = $_GET['min'];
                           $maxprijs = $_GET['max'];
                        }



                           ?>

                     <div id="filterSection" class="filter-section" style="display:none;">
                        <form method="GET" action="index#shoes">
                           <?php if(isset($_GET['q'])){ ?>
                              <input type="hidden" name="q" value="<?php echo $_GET['q']; ?>">
                           <?php } ?>
                           <label for="minPriceRange">Min Price:</label>
                           <input type="range" id="minPriceRange" name="min" min="<?php echo"$minprijs";?>" max="<?php echo"$maxprijsfinal";?>" value="<?php echo"$minprijs";?>" step="5" oninput="updateMinPriceValue(this.value)">
                           <span id="minPriceValue"><?php echo"$minprijs";?></span>
                           <label for="maxPriceRange">Max Price:</label>
                           <input type="range" id="maxPriceRange" name="max" min="<?php echo"$minprijs";?>" max="<?php echo"$maxprijsfinal";?>" value="<?php echo"$maxprijs";?>" step="5" oninput="updateMaxPriceValue(this.value)">
                           <span id="maxPriceValue"><?php echo"$maxprijs";?></span>
                           <button type="submit" class="btn btn-primary" style="background-color: #f26522; border-color:#f26522">Apply Filter</button>
                        </form>
                     </div>
                  </div>
                  <div class="header_box">
                     <div class="login_menu">
                        <ul>
                           <li><a href="wishlist">
                              <i class="fa fa-heart" aria-hidden="true"></i>
                              <span class="padding_5">Wishlist</span></a>
                           </li>
                           <li><a href="winkelwagen">
                              <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                              <span class="padding_5">Cart</span></a>
                           </li>
                           <!--recensie toevoegen ---->
                           <li><a href="recensieToevoegen.php?id=<?php echo $row['artikel_id']; ?>">
                              <i class="fa fa-comment" aria-hidden="true"></i>
                              <span class="padding_5">Add Review</span></a>
                           </li>
                           <?php
                           //Als de klant is ingelogd, laat de knop "My Profile" zien, anders laat de knop "Log-In" zien

                           if ($type == "customer" || $type == "admin"){
                              echo '<li><a href="profile">

                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span class="padding_5">My Profile</span></a>
                                    </li>';
                           }else{
                              echo '<li><a href="login">
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
               <h1 id="shoes" class="fashion_taital">Shoes</h1>
               <div class="fashion_section_2">
                  <div class="row">
                     <?php
                     // Check connection
                     if (!$mysqli) {
                        die("Connection failed: " . mysqli_connect_error());
                     }

                     

                     $conditions = [];
                     $orderBy = '';
                     
                     if (isset($_GET['q'])) {
                         $q = $_GET['q'];
                         $conditions[] = "artikelnaam LIKE '%$q%'";
                     }
                     
                     if (isset($_GET['min']) && isset($_GET['max'])) {
                         $min = $_GET['min'];
                         $max = $_GET['max'];
                         $conditions[] = "prijs BETWEEN $min AND $max";
                     }
                     
                     if (isset($_GET['s'])) {
                         $s = $_GET['s'];
                         if ($s == "abc") {
                             $orderBy = "ORDER BY artikelnaam ASC";
                         } else if ($s == "pru") {
                             $orderBy = "ORDER BY prijs ASC";
                         } else if ($s == "prd") {
                             $orderBy = "ORDER BY prijs DESC";
                         }else if ($s == "trnd") {
                             $orderBy = "ORDER BY viewcount DESC";
                         }
                     }else{
                        $orderBy = "ORDER BY viewcount DESC";
                     }
                     
                     $sql = "SELECT * FROM tblartikels a INNER join tblvariatie v on v.artikel_id=a.artikel_id";
                     if (!empty($conditions)) {
                         $sql .= " WHERE " . implode(' AND ', $conditions);
                     }
                     $sql .= " $orderBy";
                     
                     // Execute the query
                     $result = mysqli_query($mysqli, $sql);

                     


                     if (mysqli_num_rows($result) > 0) {
                        // Output data of each row
                        while($row = mysqli_fetch_assoc($result)) {
                           if($_SESSION['klant_id']) {
                           $sql2 = "SELECT artikel_id FROM tblwishlist 
                           WHERE artikel_id = " . $row['artikel_id'] . " AND klant_id = " . $_SESSION['klant_id'] . " AND variatie_id = 1";
                           $result2 = mysqli_query($mysqli, $sql2);
                           if (mysqli_num_rows($result2) > 0) {
                              $wishlist = true;
                           } else {
                              $wishlist = false;
                           }

                        }
                        $sql3 = "SELECT v.directory 
                                 FROM tblartikels a, tblvariatie v 
                                 WHERE a.artikel_id = v.artikel_id 
                                 AND a.artikel_id = '" . $row['artikel_id'] . "' 
                                 ORDER BY v.variatie_id ASC 
                                 LIMIT 1";
                        $result3 = mysqli_query($mysqli, $sql3);
                        $row3 = mysqli_fetch_assoc($result3);
                        $row['directory'] = $row3['directory'];
                        
                           echo '<div class="col-lg-4 col-sm-4">';
                           echo '   <div class="box_main">';
                           echo '      <h4 class="shirt_text">' . htmlspecialchars($row["artikelnaam"]) . '</h4>';
                           echo '      <p class="price_text">Price:  <span style="color: #262626;">$' . htmlspecialchars($row["prijs"]) . '</span></p>';
                           echo '      <div class="tshirt_img"><img src="' . htmlspecialchars($row["directory"]) . '"></div>';
                           echo '      <div class="btn_main">';

                           if($type == "guest") {
                              echo '         <div class="wishlist_bt"><a href="login"><i class="fa fa-heart-o" aria-hidden="true"></i></a></div>';

                           } else {
                           if ($wishlist) {
                              echo '         <div class="wishlist_bt"><a href="wishlistCalc?id='. $row['artikel_id'].'"><i class="fa fa-heart" aria-hidden="true"></i></a></div>';
                           } else {
                              echo '         <div class="wishlist_bt"><a href="wishlistCalc?id='. $row['artikel_id'].'"><i class="fa fa-heart-o" aria-hidden="true"></i></a></div>';
                           }
                        }
                        
                           echo '         <div class="buy_bt"><a href="cartcalc.php?id='.$row['artikel_id'].'">Add to cart</a></div>';
                           echo '         <div class="seemore_bt"><a href="productpagina?id='.$row['artikel_id'].'">See More</a></div>';
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
            <div class="footer_logo"><a href="index"><img src="images/icon/logo.svg"></a></div>

            <div class="location_main">Help Line  Number : +32 41 23 45 97 80
            <?php
            socialmedia();
            ?>
         </div>
         </div>
      </div>
      <!-- footer section end -->
      <!-- copyright section start -->
      <div class="copyright_section">
         <div class="container">
            <p class="copyright_text">© 2024 Myshoes All Rights Reserved. <br> <a href="retourbeleid.html">Retourbeleid</a> </p>
         </div>
      </div>
      <!-- copyright section end -->
      <script>
         document.getElementById("filterBtn").onclick = function(event) {
            event.stopPropagation();
            var filterSection = document.getElementById("filterSection");
            var bannerTitle = document.querySelector("h1.banner_taital");
            var bannerSection = document.querySelector("div.banner_section.layout_padding");
            if (filterSection.style.display === "none" || filterSection.style.display === "") {
               filterSection.style.display = "block";
               bannerTitle.style.display = "none";
               bannerSection.style.display = "none";
            } else {
               filterSection.style.display = "none";
               bannerTitle.style.display = "block";
               bannerSection.style.display = "block";
            }
         };

         document.getElementById("sortBtn").onclick = function(event) {
            event.stopPropagation();
            var sortOptionsContainer = document.getElementById("sortOptionsContainer");
            if (sortOptionsContainer.classList.contains("show")) {
                sortOptionsContainer.classList.remove("show");
            } else {
                sortOptionsContainer.classList.add("show");
            }
         };

         document.addEventListener("click", function(event) {
            var filterSection = document.getElementById("filterSection");
            var filterBtn = document.getElementById("filterBtn");
            var sortOptionsContainer = document.getElementById("sortOptionsContainer");
            var sortBtn = document.getElementById("sortBtn");
            if (!filterSection.contains(event.target) && !filterBtn.contains(event.target)) {
               filterSection.style.display = "none";
               document.querySelector("h1.banner_taital").style.display = "block";
               document.querySelector("div.banner_section.layout_padding").style.display = "block";
            }
            if (!sortOptionsContainer.contains(event.target) && !sortBtn.contains(event.target)) {
                sortOptionsContainer.classList.remove("show");
            }
         });

         function updateMinPriceValue(value) {
            var maxPriceRange = document.getElementById("maxPriceRange");
            if (parseInt(value) > parseInt(maxPriceRange.value)) {
               maxPriceRange.value = value;
               document.getElementById("maxPriceValue").innerText = value;
            }
            document.getElementById("minPriceValue").innerText = value;
         }

         function updateMaxPriceValue(value) {
            var minPriceRange = document.getElementById("minPriceRange");
            if (parseInt(value) < parseInt(minPriceRange.value)) {
               minPriceRange.value = value;
               document.getElementById("minPriceValue").innerText = value;
            }
            document.getElementById("maxPriceValue").innerText = value;
         }
      </script>
   </body>
</html>
   </body>
</html>