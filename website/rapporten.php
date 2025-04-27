<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapporten</title>
    <!-- Include your CSS files here -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <link rel="icon" href="images/icon/favicon.png">
</head>

<body>
    <?php
    include 'connect.php';
    session_start();
    include 'functies/functies.php';
    controleerAdmin($mysqli);
    include 'functies/adminSideMenu.php';

    $maand = isset($_GET['maand']) ? intval($_GET['maand']) : date('m');
    $jaar = isset($_GET['jaar']) ? intval($_GET['jaar']) : date('Y');

    $maandelijkeRapportData = generererMaandelijksRapport($maand, $jaar, $mysqli);
    $jaarlijkeRapportData = genereerJaarliksRapport($jaar, $mysqli);

    $maandelijkeRapport = $maandelijkeRapportData['report'];
    $maandTotalRevenue = $maandelijkeRapportData['totalRevenue'];
    $maandTotalCost = $maandelijkeRapportData['totalCost'];
    $maandProfit = $maandelijkeRapportData['profit'];

    $jaarlijkeRapport = $jaarlijkeRapportData['report'];
    $jaarTotalRevenue = $jaarlijkeRapportData['totalRevenue'];
    $jaarTotalCost = $jaarlijkeRapportData['totalCost'];
    $jaarProfit = $jaarlijkeRapportData['profit'];
    ?>

    <div class="container">
        <h1>Rapporten</h1>
        <form method="GET" action="rapporten.php">
            <label for="maand">Select Month:</label>
            <select name="maand" id="maand">
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    $selected = ($i == $maand) ? 'selected' : '';
                    echo "<option value='$i' $selected>" . date('F', mktime(0, 0, 0, $i, 10)) . "</option>";
                }
                ?>
            </select>
            <label for="jaar">Enter Year:</label>
            <input type="number" name="jaar" id="jaar" value="<?php echo $jaar; ?>" min="2000" max="<?php echo date('Y'); ?>">
            <input type="submit" value="View Report">
        </form>

        <h2>Monthly Report for <?php echo $maand . '/' . $jaar; ?></h2>
        <p>Total Revenue: €<?php echo number_format($maandTotalRevenue, 2); ?></p>
        <p>Total Cost: €<?php echo number_format($maandTotalCost, 2); ?></p>
        <p>Profit: €<?php echo number_format($maandProfit, 2); ?></p>
        
        <h2>Yearly Report for <?php echo $jaar; ?></h2>
        <p>Total Revenue: €<?php echo number_format($jaarTotalRevenue, 2); ?></p>
        <p>Total Cost: €<?php echo number_format($jaarTotalCost, 2); ?></p>
        <p>Profit: €<?php echo number_format($jaarProfit, 2); ?></p>
        
    </div>

    <style>
        body {
            display: flex;
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            flex: 1;
            margin-left: 250px; /* Adjust this value based on the width of your side menu */
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .tableContainer {
            width: 100%;
            overflow-x: auto;
            margin-top: 20px;
        }

        .adminTable {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .adminTable th, .adminTable td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .adminTable th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .adminTable tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        h1, h2 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        form label, form select, form input {
            margin-right: 10px;
        }
    </style>
</body>

</html>