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
    <title>Manage Orders</title>
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
    <!-- owl stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Poppins:400,700&display=swap&subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <link rel="icon" href="images/icon/favicon.png">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        table {
            width: 90%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 50px auto;
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
        .price-column {
            width: 50px !important; /* Adjust the width as needed */
        }
        select {
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 5px;
            background-color: #fff;
            color: #333;
        }
    </style>
</head>
<body>
<?php
include 'connect.php';
session_start();
include 'functies/functies.php';
controleerAdmin();
include 'functies/adminSideMenu.php';
?>
<div class="adminpage1">
    <br>
    <h1>Orders</h1>
    <br>
    <?php
    $query = 'SELECT * FROM tblorders';
    $result = $mysqli->query($query);
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Order ID</th><th>Costumer ID</th><th class='price-column'>Price</th><th>Personal message</th></tr>";
        while ($row = $result->fetch_assoc()) {
        

            echo "<tr>";
            echo "<td>" . $row['order_id'] . "</td>";
            echo "<td>" . $row['klant_id'] . "</td>";
            echo "<td class='price-column'>" . $row['totaalbedrag'] . "</td>";
            echo "<td>" . $row['persoonlijke_bericht'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No products found.";
    }
    $result->close();
    $mysqli->close(); // Close the MySQL connection
    ?>
    <br>
</div>
</body>
</html>
