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
      /* General table styles */
      table {
          width: 100%;
          margin-top: 50px;
          border-collapse: collapse;
      }

      table th, table td {
          padding: 15px;
          text-align: center;
          border: 1px solid #ddd;
      }

      table th {
          background-color: #f8f9fa; 
          color: #333;
          font-weight: bold;
          text-transform: uppercase;
      }

      table td img {
          width: 100px;
          height: auto;
          border-radius: 5px; 
      }

      table td {
          vertical-align: middle;
          font-size: 1.1em;
          color: #555; 
      }

      table tr:nth-child(even) {
          background-color: #f2f2f2; 
      }

      /* Cart container styles */
      .cart-container {
          max-width: 1200px;
          margin: 0 auto;
          padding: 20px;
      }

      /* Total price display */
      .cart-total {
          margin-top: 20px;
          padding: 10px;
          background-color: #f8f9fa;
          font-size: 1.5em;
          font-weight: bold;
          color: #333;
          text-align: right;
          border-top: 2px solid #ddd;
      }

      /* Empty cart message */
      .empty-cart {
          text-align: center;
          font-size: 1.5em;
          margin-top: 50px;
          color: #888;
      }

      /* Responsive design adjustments */
      @media (max-width: 768px) {
          table th, table td {
              font-size: 14px;
          }

          table td img {
              width: 60px;
          }
      }
      </style>
   </head>
   <body>

   <?php
include("connect.php");
session_start();

if (isset($_SESSION["klant_id"])) {
    $klant_id = $_SESSION["klant_id"];
    $sql = "SELECT w.artikel_id, w.aantal, a.directory, a.artikelnaam, a.prijs 
            FROM tblwinkelwagen w, tblartikels a 
            WHERE klant_id = '" . $klant_id . "' 
            AND w.artikel_id = a.artikel_id";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $totalePrijs = 0; 

        echo '<div class="cart-container">';
        echo '<table class="cart-table">';
        echo '<thead>'; 
        echo '<tr>';
        echo '<th>Product</th>';
        echo '<th>Artikelnaam</th>';
        echo '<th>Aantal</th>';
        echo '<th>Prijs per item</th>'; 
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) {
            $itemPrijs = $row["prijs"] * $row["aantal"]; 
            $totalePrijs += $itemPrijs; 
            
            echo '<tr>';
            echo '<td><img src="' . $row["directory"] . '" alt="' . $row["artikelnaam"] . '"></td>';
            echo '<td>' . $row["artikelnaam"] . '</td>';
            echo '<td>' . $row["aantal"] . '</td>';
            echo '<td>&euro;' . $row["prijs"] . '</td>'; 
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';

        echo '<div class="cart-total">Totale Prijs: &euro;' . $totalePrijs . '</div>';
        echo '</div>'; 
    } else {
        echo '<div class="empty-cart">Winkelwagen is leeg.</div>';
    }
} else {
    echo '<div class="empty-cart">U bent niet ingelogd. Log eerst in om de winkelwagen te bekijken.</div>';
}
?>

   </body>
</html>
