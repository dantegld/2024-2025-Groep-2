<!DOCTYPE html>
<html lang="en">
   <head>      
    <?php
      include 'connect.php';
         include 'functies/functies.php';
         onderhoudsModus();

         $id = $_GET['id'];
         if (!(isset($_SESSION["klant"]))) {
            $_SESSION["klant"] = false;
         }

         $sql = "SELECT * FROM tblartikels WHERE artikel_id = $id";
         $result = mysqli_query($mysqli, $sql);
         $row = mysqli_fetch_assoc($result);
         $artikelnaam = $row['artikelnaam'];
      ?>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <?php
         echo '<title>' . $artikelnaam . '</title>';
         ?>
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
    <style>
html {
    scroll-behavior: auto;
}
.dropdown {
    position: relative;
    width: 200px;
}

select {
    appearance: none; /* Remove default styling */
    -webkit-appearance: none; /* Remove default styling in Safari */
    -moz-appearance: none; /* Remove default styling in Firefox */
    
    width: 100%;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: white;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="%23999"><path d="M5 8l5 5 5-5H5z"/></svg>');
    background-repeat: no-repeat;
    background-position: right 15px center;
    background-size: 1em;
    font-size: 16px;
    transition: border-color 0.3s ease;
}

select:focus {
    border-color: #007bff; /* Change border color on focus */
    outline: none; /* Remove outline */
}

select:hover {
    border-color: #0056b3; /* Darker border color on hover */
}

select:disabled {
    color: #6c757d; /* Grey color for disabled select */
    background-color: #e9ecef; /* Light grey background for disabled select */
    cursor: not-allowed;
}
</style>
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
            <div class="container1">
               <div class="containt_main1">
                  <?php
                  include 'functies/MySideNav.php';
                  ?>
                  <span class="toggle_icon" onclick="openNav()"><img  width="44px" src="images/icon/Hamburger_icon.svg.png"></span>
                 
                  <div class="header_box">
                     <div class="login_menu">
                        <ul>
                           <li><a class="black" href="wishlist.php">
                              <i class="fa fa-heart" aria-hidden="true"></i>
                              <span class="padding_5">Wishlist</span></a>
                           </li>
                           <li><a class="black" href="winkelwagen.php">
                              <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                              <span class="padding_5">Cart</span></a>
                           </li>
                           <?php
                           //Als de klant is ingelogd, laat de knop "My Profile" zien, anders laat de knop "Log-In" zien
                           if ($_SESSION["klant"]){
                              echo '<li><a class="black" href="profile.php">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span class="padding_5">My Profile</span></a>
                                    </li>';
                           }else{
                              echo '<li><a class="black" href="login.php">
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
         <div class="container2">
         <div class="banner_section layout_padding">
            <div class="container">
                              <h1 class="banner_taital">Gratis Verzending Boven &euro;50</h1>
                           </div>
                           </div>
                        </div>
                     </div>
                  </div>   
               </div>
            </div>
         </div>
                <br>
                <br>                      
         <div class="productpagina">
    <div class="product-container">
        <div class="product-image">
        <a href="index.php">&#8592; Back</a>
            <?php
            $variatie_id = isset($_GET['variatie_id']) ? intval($_GET['variatie_id']) : 1;
            $sql = "SELECT * FROM tblartikels, tblvariatie WHERE tblvariatie.artikel_id = $id AND tblartikels.artikel_id = tblvariatie.artikel_id AND tblvariatie.variatie_id = $variatie_id";
            $result = mysqli_query($mysqli, $sql);
            $row = mysqli_fetch_assoc($result);
            $afbeelding = $row['directory'];
            $artikel_id = $row['artikel_id'];
            echo '<img width="300px" src="' . $afbeelding . '" alt="' . $row['artikelnaam'] . ' Image">';
            ?>
        </div>
        <div class="product-details" id="product-details">
            <?php
            if($_SESSION['klant']){
                $sql = "SELECT * FROM tblwishlist WHERE artikel_id = $id and klant_id = '" . $_SESSION['klant_id'] . "' and variatie_id = $variatie_id";
                $result = mysqli_query($mysqli, $sql);
                if(mysqli_num_rows($result) > 0){
                    echo '<div class="wishlist_bt"><a href="wishlistCalc1.php?variatie_id='.$variatie_id .'&'. 'id='. $artikel_id.'"><i class="fa fa-heart" aria-hidden="true"></i></a></div>';
                }else{
                    echo '<div class="wishlist_bt"><a href="wishlistCalc1.php?variatie_id='.$variatie_id .'&'. 'id='. $artikel_id.'"><i class="fa fa-heart-o" aria-hidden="true"></i></a></div>';
                }

            }else{
                echo '<div class="wishlist_bt"><a href="login.php"><i class="fa fa-heart-o" aria-hidden="true"></i></a></div>';
            }
            ?>
            <br>
            <br>
    <h1 class="product-title"><?php echo $row['artikelnaam']; ?></h1>
    <p class="product-price">&euro; <?php echo $row['prijs']; ?></p>
    <form id="colorForm" action="" method="GET">
        <div class="color-selector">
        <h3>Select Color:</h3>
<div class="colors">
    <?php
    $sql = "SELECT * FROM tblvariatie,tblkleur WHERE artikel_id = $id and tblvariatie.kleur_id = tblkleur.kleur_id";
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="color" style="background-color:' . $row['HEX'] . '" data-color="' . $row['kleur'] . '" onclick="selectColor(' . $row['variatie_id'] . ')"></div>';
    }
    ?>
</div>
</div>
<input type="hidden" name="variatie_id" id="variatie_id" value="<?php echo $variatie_id; ?>">
<?php
// Preserve existing GET parameters
foreach ($_GET as $key => $value) {
    if ($key != 'variatie_id') {
        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
    }
}
?>
</form>
<div class="dropdown">
    <?php
    echo '<select class="mySelect" name="schoenmaat" id="schoenmaat" onchange="updateCartLink()">';
    for ($i = 30; $i <= 50; $i++) {
        echo '<option value="' . $i . '">' . $i . '</option>';
    }
    echo '</select>';
    echo '<br>';
    echo '<br>';
    ?>
    <div class="buy_bt">
        <a id="addToCartLink" href="cartCalc.php?variatie_id=<?php echo $variatie_id; ?>&id=<?php echo $artikel_id; ?>&schoenmaat=">Add to cart</a>
    </div>
</div>
</div>
</div>
</div>

<script>
function selectColor(variatie_id) {
    document.getElementById('variatie_id').value = variatie_id;
    // Append the fragment to the form action URL
    document.getElementById('colorForm').action = window.location.pathname + window.location.search + '#product-details';
    document.getElementById('colorForm').submit();
}

function updateCartLink() {
    var schoenmaat = document.getElementById('schoenmaat').value;
    var variatie_id = document.getElementById('variatie_id').value;
    var artikel_id = <?php echo $artikel_id; ?>;
    var addToCartLink = document.getElementById('addToCartLink');
    addToCartLink.href = 'cartCalc.php?variatie_id=' + variatie_id + '&id=' + artikel_id + '&schoenmaat=' + schoenmaat;
}
</script>
</body>
</html>