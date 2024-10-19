<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pagina</title>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Admin Pagina</title>
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
<style>
         body {
             font-family: 'Poppins', sans-serif;
             background-color: #f5f5f5;
             margin: 0;
             padding: 0;
         }
         table {
            width: 60%;
             border-collapse: collapse;
             background-color: #fff;
             box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
         }
         th, td {
             padding: 10px;
             text-align: center;
             border: 1px solid #ddd;
         }
         th {
             background-color: #007BFF;
             color: white;
             font-weight: normal;
         }
         td {
             color: #333;
         }
         tr:nth-child(even) {
             background-color: #f2f2f2;
         }
         input[type="submit"] {
             background-color: #ff4d4d;
             color: white;
             border: none;
             padding: 10px 15px;
             cursor: pointer;
             border-radius: 5px;
             font-size: 14px;
             transition: background-color 0.3s ease;
         }
         input:hover {
             background-color: #e60000;
         }
         .message {
             text-align: center;
             font-size: 18px;
             color: #333;
             margin-top: 20px;
         }
         .message.success {
             color: #28a745;
         }
         .message.error {
             color: #dc3545;
         }
         form {
             display: inline;
         }
         .container {
             text-align: center;
             padding: 20px;
         }
         input[type="number"],input[name="artikelnaam"] {
             border: none;
             background-color: transparent;
             text-align: center;
         }
      </style>
    <?php
    include 'connect.php';
    include 'functies/functies.php';
    controleerAdmin();
    include 'functies/adminSideMenu.php';

    echo '<div class="adminpage">';
    $artikel_id = $_GET['artikel_id'];
    $sql = "SELECT * from tblvariatie,tblartikels,tblkleur where tblvariatie.artikel_id = tblartikels.artikel_id and tblvariatie.artikel_id = $artikel_id and tblvariatie.kleur_id = tblkleur.kleur_id group by tblvariatie.variatie_id";
    $result = $mysqli->query($sql);
    echo '<table border="1">';
    echo '<tr><th>Variatie ID</th><th>Artikel</th><th>Foto</th><th>Stock</th><th>Delete</th></tr>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['variatie_id'] . '</td>';
        echo '<td>' . $row['artikelnaam'] . ' ' . $row['kleur'] . '</td>';
        echo '<td><a class="btn btn-primary" href="fotos.php?artikel_id=' . $artikel_id . '&variatie_id='.$row['variatie_id']. '">Foto Aanpassen</td>';
        echo '<td><a class="btn btn-primary" href="stock.php?artikel_id=' . $artikel_id . '&variatie_id='.$row['variatie_id']. '">Stock Aanpassen</td>';
        echo '<td><a href="delete_variant.php?artikel_id=' . $artikel_id . '&variatie_id='.$row['variatie_id']. '"><i class="fa fa-trash lg" aria-hidden="true"></i></td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '<br>';
    echo '<a class="btn btn-primary" href="add_variant.php?artikel_id=' . $artikel_id . '">Add Variant</a>';
    echo '</div>';
    ?>