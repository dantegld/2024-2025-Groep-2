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
      <title>My Orders</title>
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

      table td {
          vertical-align: middle;
          font-size: 1.1em;
          color: #555; 
      }

      table tr:nth-child(even) {
          background-color: #f2f2f2; 
      }

      /* Card container styles */
      .card-container {
          max-width: 1200px;
          margin: 0 auto;
          padding: 20px;
      }

      /* Card styles */
      .card {
          border: 1px solid #ddd;
          border-radius: 5px;
          margin-bottom: 20px;
      }

      .card-header {
          background-color: #f8f9fa;
          padding: 10px;
          font-size: 1.5em;
          font-weight: bold;
          color: #333;
      }

      .card-body {
          padding: 10px;
      }

      .card-footer {
          background-color: #f8f9fa;
          padding: 10px;
          font-size: 1.2em;
          font-weight: bold;
          color: #333;
          text-align: right;
      }
      </style>
   </head>
   <body>
   <div>
   <?php
include("connect.php");
session_start();
include 'functies/functies.php';
controleerKlant($mysqli);
onderhoudsModus($mysqli);
include 'functies/mySideNav.php';
echo '<br><span class="toggle_icon1" onclick="openNav()"><img width="44px" src="images/icon/Hamburger_icon.svg.png"></span>'; 

// Return processing (with 'isset' and button name via POST)
if (isset($_POST['retour'])) {
    // Get the POST data from the button
    $verkoop_id = $_POST['verkoop_id'];
    $artikel_id = $_POST['artikel_id'];
    $klant_id = $_SESSION['klant_id'];  // Assumes the customer is logged in

    // Get the receipt date of the order
    $query = "SELECT ontvangstdatum FROM tblaankoop WHERE verkoop_id = '$verkoop_id' AND klant_id = '$klant_id'";
    $result = mysqli_query($mysqli, $query);
    $row = mysqli_fetch_array($result);
    $ontvangstdatum = $row['ontvangstdatum'];

    // Calculate the number of days since receipt
    $huidige_datum = date('Y-m-d');
    $verschil = (strtotime($huidige_datum) - strtotime($ontvangstdatum)) / (60 * 60 * 24);

    // Check if it falls within 3 days
    
        // Return is valid
        // Add the return request to the tblGeretourneerdeProducten table
        
        $queryInsert = "INSERT INTO tblGeretourneerdeProducten (verkoop_id, artikel_id, klant_id) VALUES ('$verkoop_id', '$artikel_id', '$klant_id')";
        $resultInsert = mysqli_query($mysqli, $queryInsert);

        if ($resultInsert) {
            // Successful entry
            echo "<div class='alert alert-success'>Return request successfully submitted!</div>";
        } else {
            // Error during entry
            echo "<div class='alert alert-danger'>An error occurred while submitting the return request.</div>";
        }
}

// Fetch and display orders
$query = "SELECT * FROM tblaankoop WHERE klant_id = '".$_SESSION['klant_id']."'";
$result = mysqli_query($mysqli, $query);

while ($row = mysqli_fetch_array($result)) {
    echo '<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Order #'.$row['verkoop_id'].'</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Order Status</th>
                            </tr>
                        </thead>
                        <tbody>';
                        
    $query2 = "SELECT * FROM tblartikels WHERE artikel_id = '".$row['artikel_id']."'";
    $result2 = mysqli_query($mysqli, $query2);
    $row2 = mysqli_fetch_array($result2); 
    $totaal = $row2['prijs'] * $row['aantal'];

    echo '<tr>
            <td>'.$row2['artikelnaam'].'</td>
            <td>'.$row['aantal'].'</td>
            <td>€'.$row2['prijs'].'</td>
            <td>€'. $totaal.'</td>';
            $statusSql = "SELECT status FROM tblaankoop WHERE verkoop_id = '".$row['verkoop_id']."'";
            $statusResult = mysqli_query($mysqli, $statusSql);
            $statusRow = mysqli_fetch_array($statusResult);
            echo '<td>'.$statusRow['status'].'</td>';
            

    echo '</tr>';
                        
    echo '</tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <h3>Total: €'.$totaal.'</h3>
                </div>
            </div>
        </div>
    </div>';
}
?>
</div>
</body>
</html>
