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
      .pay{
          text-align: right;
          margin-top: 20px;
      }

      /* Empty cart message */
      .empty-cart {
          text-align: center;
          font-size: 1.5em;
          margin-top: 50px;
          color: #888;
      }

      /* Quantity buttons */
      .quantity-btn {
          padding: 5px 10px;
          font-size: 16px;
          margin: 0 5px;
          cursor: pointer;
          background-color: #f8f9fa;
          border: 1px solid #ddd;
          border-radius: 5px;
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
   <div>
   <?php
include("connect.php");
session_start();
include 'functies/functies.php';
controleerKlant();
onderhoudsModus();
include 'functies/mySideNav.php';
echo '<br><span class="toggle_icon1" onclick="openNav()"><img width="44px" src="images/icon/Hamburger_icon.svg.png"></span>';


if (isset($_SESSION["klant_id"])) {
    $klant_id = $_SESSION["klant_id"];
    $sql = "SELECT w.id, w.artikel_id, w.aantal, w.schoenmaat,a.prijs,a.artikelnaam, w.variatie_id, v.variatie_id, k.kleur, v.directory 
            FROM tblwinkelwagen w, tblvariatie v, tblartikels a,tblkleur k
            WHERE klant_id =  $klant_id
            AND w.artikel_id = v.artikel_id
            AND w.artikel_id = a.artikel_id
            AND w.variatie_id = v.variatie_id
            AND v.kleur_id = k.kleur_id";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $totalePrijs = 0; 

        echo '<div class="cart-container">';
        echo '<table class="cart-table">';
        echo '<thead>'; 
        echo '<tr>';
        echo '<th>Article</th>';
        echo '<th>Article name</th>';
        echo '<th>Amount</th>';
        echo '<th>Price per item</th>'; 
        echo '<th>Total per item</th>';
        echo '<th>Shoe size</th>';
        echo '<th>Delete</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) {
            $itemPrijs = $row["prijs"] * $row["aantal"]; 
            $totalePrijs += $itemPrijs; 
            
            echo '<tr id="product-' . $row['artikel_id'] . '">';
            echo '<td><img src="' . $row["directory"] . '" alt="' . $row["artikelnaam"] . '"></td>';
            echo '<td><a href="productpagina?id=' . $row["artikel_id"] . '&variatie_id=' . $row["variatie_id"] . '">' . $row["artikelnaam"] . '<br>' . $row["kleur"] . '</a></td>';
            echo '<td>
                    <button class="quantity-btn" onclick="updateQuantity(' . $row['artikel_id'] . ', \'decrease\')">-</button>
                    <span id="quantity-' . $row['artikel_id'] . '">' . $row["aantal"] . '</span>
                    <button class="quantity-btn" onclick="updateQuantity(' . $row['artikel_id'] . ', \'increase\')">+</button>
                  </td>';
            echo '<td>&euro;<span id="price-' . $row['artikel_id'] . '">' . number_format($row["prijs"], 2) . '</span></td>';
            echo '<td>&euro;<span id="total-' . $row['artikel_id'] . '">' . number_format($itemPrijs, 2) . '</span></td>';
            echo '<td>
        <select onchange="updateSchoenmaat(' . $row['id'] . ', this.value)">
            <option value="30"' . ($row["schoenmaat"] == 30 ? ' selected' : '') . '>30</option>
            <option value="31"' . ($row["schoenmaat"] == 31 ? ' selected' : '') . '>31</option>
            <option value="32"' . ($row["schoenmaat"] == 32 ? ' selected' : '') . '>32</option>
            <option value="33"' . ($row["schoenmaat"] == 33 ? ' selected' : '') . '>33</option>
            <option value="34"' . ($row["schoenmaat"] == 34 ? ' selected' : '') . '>34</option>
            <option value="35"' . ($row["schoenmaat"] == 35 ? ' selected' : '') . '>35</option>
            <option value="36"' . ($row["schoenmaat"] == 36 ? ' selected' : '') . '>36</option>
            <option value="37"' . ($row["schoenmaat"] == 37 ? ' selected' : '') . '>37</option>
            <option value="38"' . ($row["schoenmaat"] == 38 ? ' selected' : '') . '>38</option>
            <option value="39"' . ($row["schoenmaat"] == 39 ? ' selected' : '') . '>39</option>
            <option value="40"' . ($row["schoenmaat"] == 40 ? ' selected' : '') . '>40</option>
            <option value="41"' . ($row["schoenmaat"] == 41 ? ' selected' : '') . '>41</option>
            <option value="42"' . ($row["schoenmaat"] == 42 ? ' selected' : '') . '>42</option>
            <option value="43"' . ($row["schoenmaat"] == 43 ? ' selected' : '') . '>43</option>
            <option value="44"' . ($row["schoenmaat"] == 44 ? ' selected' : '') . '>44</option>
            <option value="45"' . ($row["schoenmaat"] == 45 ? ' selected' : '') . '>45</option>
            <option value="46"' . ($row["schoenmaat"] == 46 ? ' selected' : '') . '>46</option>
            <option value="47"' . ($row["schoenmaat"] == 47 ? ' selected' : '') . '>47</option>
            <option value="48"' . ($row["schoenmaat"] == 48 ? ' selected' : '') . '>48</option>
            <option value="49"' . ($row["schoenmaat"] == 49 ? ' selected' : '') . '>49</option>
            <option value="50"' . ($row["schoenmaat"] == 50 ? ' selected' : '') . '>50</option>
        </select>
          </td>';
          echo '<td><a href="verwijderenWinkelwagen?id=' . $row['id'] . '"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a></td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        if(isset($_POST['verstuur'])) {
            // Debug: Controleer de waarde van $totaal
            $kortingscode = $_POST['kortingscode'];
                $sqlDiscount = "SELECT * FROM `tblkortingscodes` WHERE kortingscode = '". $kortingscode ."'";
                $resultDiscount = $mysqli->query($sqlDiscount);
                if ($resultDiscount->num_rows > 0) {
                while ($row = $resultDiscount->fetch_assoc()) {

                    $gebruik_aantal = $row['gebruik_aantal'];
                            $gebruik_aantal += 1;
                            // code voor het opslaan van gebruik_aantal
                            $sqlGebruikAantal = "UPDATE tblkortingscodes SET gebruik_aantal = '".$gebruik_aantal."' WHERE kortingscode = '".$kortingscode."'";
                            $resultGebruikAantal = $mysqli->query($sqlGebruikAantal);

                $discountPrice = (float) $row['korting_euro'];  
             
                if (strtotime($row['einddatum']) >= strtotime(date("Y-m-d"))) {
                    // Kortingscode is geldig
                    $totalePrijs = $totalePrijs * (1 - $discountPrice / 100);
                    echo "<span style=\"color: green;\">The promo code has been used succesfully.</span>";
           
                    
                } else {
                    echo "Kortingscode is verlopen.";
                }
                
            }
        }
            }

            echo '<div class="cart-total">Total Price: &euro;<span id="total-price">' . number_format($totalePrijs, 2) . '</span></div>';
            $_SESSION['total_price'] = number_format($totalePrijs, 2);
            echo '<br>';
            echo "enter a discount code: <br>";
    
    
            echo "<form method='POST' action='winkelwagen'>";
            echo "<input type='text' name='kortingscode'/>";
            echo "<input type='submit'  value='test' name='verstuur' />";
            echo "</form>";
            ?>
            <?php
       
            //Fetch active delivery options
    
            $sql = "SELECT * FROM tblbezorgopties WHERE actief = 1";
            $result = $mysqli->query($sql);
            if ($result->num_rows > 0) {
                echo '<div class="delivery-options">';
                echo '<label for="delivery-option">Choose a delivery option:</label> <br>';
                echo '<select id="delivery-option" name="delivery_option">';
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['methode_id'] . '">' . $row['methodenaam'] . '</option>';
                }
                echo '</select>';
                echo '</div>';
            }
    
            //Check if home delivery is active
            $sql = "SELECT * FROM tblbezorgopties WHERE methodenaam = 'Laten leveren' AND actief = 1";
            $result = $mysqli->query($sql);
            if ($result->num_rows > 0) {
                // Fetch address from profile
                $sql = "SELECT * FROM tbladres WHERE klant_id = '$_SESSION[klant_id]'";
                $result = $mysqli->query($sql);
                if ($result->num_rows == 0) {
                    echo '<div class="address-warning">Please <a href="profile">add an address</a> to enable home delivery.</div>';
                }
            }
            
    
      echo ' <div class= "pay"><a href="betalen" class="btn btn-primary">Checkout</a></div>';
           echo "</form>";
            echo '</div>'; 




        }else {
            echo '<div class="empty-cart">Cart is empty</div>';
        }
    }else {
        echo '<div class="empty-cart">Log in to use shopping cart</div>';
    }
    
    $mysqli->close();
     
        

?>

   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
   function updateQuantity(artikel_id, action) {
       $.ajax({
           url: 'update_winkelwagen.php',
           type: 'POST',
           data: {
               artikel_id: artikel_id,
               action: action
           },
           success: function(response) {
               // Parse the JSON response
               var data = JSON.parse(response);

               // Update the quantity, price and total price dynamically
               $('#quantity-' + artikel_id).text(data.new_quantity);
               $('#total-' + artikel_id).text(data.new_total_price);
               $('#total-price').text(data.new_total_cart_price);
           }
       });
   }
   function openNav() {
           document.getElementById("mySidenav").style.width = "250px";
         }
         
         function closeNav() {
           document.getElementById("mySidenav").style.width = "0";
         }

         function updateSchoenmaat(id, schoenmaat) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_schoenmaat.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                console.log("Schoenmaat updated successfully: " + xhr.responseText);
            } else {
                console.error("Error updating schoenmaat: " + xhr.responseText);
            }
        }
    };
    xhr.send("id=" + encodeURIComponent(id) + "&schoenmaat=" + encodeURIComponent(schoenmaat));
}
   </script>
</div>
   </body>
</html>
