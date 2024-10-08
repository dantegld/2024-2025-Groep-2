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
</body>
<?php
include 'connect.php'; 


$query = "SELECT * FROM tblartikels WHERE stock = 0";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Artikel ID</th><th>Artikelnaam</th><th>Prijs</th><th>Actie</th></tr>";


    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['artikel_id'] . "</td>";
        echo "<td>" . $row['artikelnaam'] . "</td>";
        echo "<td>" . $row['prijs'] . "</td>";
        echo "<td>
                <form method='POST' action=''>
                    <input type='hidden' name='artikel_id' value='" . $row['artikel_id'] . "' />
                    <input type='submit' name='delete' value='Verwijderen' />
                </form>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Geen oude of niet-beschikbare producten gevonden.";
}


if (isset($_POST['delete'])) {
    $artikel_id = $_POST['artikel_id'];


    $deleteQuery = "DELETE FROM tblartikels WHERE artikel_id = $artikel_id";
    $deleteResult = $conn->query($deleteQuery);

    if ($deleteResult) {
        echo "Het product met ID $artikel_id is succesvol verwijderd.";
     
        header("Refresh:0");
    } else {
        echo "Er is een fout opgetreden bij het verwijderen van het product.";
    }
}
?>
