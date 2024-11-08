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
      <title>Product Toevoegen</title>
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
   <?php
   session_start();
   include 'connect.php'; 
      include 'functies/functies.php';
      controleerAdmin();
      include 'functies/adminSideMenu.php';
        ?>
        <div class="adminpage1">
      <div class="schoenenForm">
        <form class="formFlex" action="upload.php" method="POST" enctype="multipart/form-data">
         <div>
            <label>Naam</label>
            <input type="text" name="naam" class="form-control" required><br>
            <label>Stock</label>
            <input type="number" name="stock" class="form-control" required><br>
            <label>Prijs</label>
            <input type="number" name="prijs" class="form-control" required><br>
            <label>Aankoopprijs</label>
            <input type="number" name="aankoopprijs" class="form-control" required><br>
            <label>Kleur 1</label>
            <input type="text" name="kleur1" class="form-control" required><br>
            <label>Kleur 2</label>
            <input type="text" name="kleur2" class="form-control"><br>
            <label>Kleur 3</label>
            <input type="text" name="kleur3" class="form-control"><br>
            </div>
            <div>
            <label>Categorie</label>
            <input type="text" name="categorie" class="form-control" required><br>
            <label>Merk</label>
            <input type="text" name="merk" class="form-control" required><br>
            <label>Image kleur 1</label>
            <input type="file" name="image1" class="form-control" required><br>
            <label>Image Kleur 2</label>
            <input type="file" name="image2" class="form-control" ><br>
            <label>Image Kleur 3</label>
            <input type="file" name="image3" class="form-control" ><br>

            <input type="submit" name="submit" value="Toevoegen" class="btn btn-primary">
         </div>
         </div>

        </form>






        </div>