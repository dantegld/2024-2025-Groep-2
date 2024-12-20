
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Promotions Overview</title>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Active Promotions Overview</title>
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
    <?php
    include 'connect.php';
    session_start();
    include 'functies/functies.php';
    controleerAdmin();
    include 'functies/adminSideMenu.php';
    ?>

    <!-- Lopende promoties overzicht pagina -->
    <div class="adminpageCenter">
        <h1>Active Promotions Overview</h1>
        <?php
        //sql query om alle actieve promotiecodes te selecteren
        $sql = "SELECT kortingscode, korting_euro, einddatum, gebruik_aantal FROM tblkortingscodes WHERE einddatum >= CURDATE()";
        $resultaat = $mysqli->query($sql);

        //printen van de promoties
        if ($resultaat->num_rows > 0) {
            echo '<table border="1">';
            echo '<tr><th>Promotion Code</th><th>Discount (€)</th><th>End Date</th><th>Usage Count</th></tr>';
            while ($row = $resultaat->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['kortingscode']) . '</td>';
                echo '<td>' . htmlspecialchars($row['korting_euro']) . '</td>';
                echo '<td>' . htmlspecialchars($row['einddatum']) . '</td>';
                echo '<td>' . htmlspecialchars($row['gebruik_aantal']) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No active promotions found.</p>';
        }

        $resultaat->close();
        $mysqli->close();
        ?>
    </div>
</body>
</html>