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
    <?php
    include 'connect.php';
    // check if the user is logged in
    include 'functies/functies.php';
    controleerAdmin();
    include 'functies/adminSideMenu.php';
    ?>
    
    <div class="adminpage">
        <?php
        $sql = "SELECT * FROM tblklant WHERE klant_id = '$_SESSION[klant_id]'";
        $result = $mysqli->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo '<h2>Adminpagina Myshoes</h2>';
            echo '<h4>Welkom, ' . $row['klantnaam'] . '.</h4>';
        }
        ?>
        <h3>Betaalmethodes</h3>
        <table>
            <tr>
                <th>Betaalmethode</th>
                <th>Actief</th>
                <th>Verwijderen</th>
            </tr>
            <?php
            $sql = "SELECT * FROM tblbetaalmethodes";
            $result = $mysqli->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['betaalmethode'] . '</td>';
                echo '<td>'; 
                if ($row['actief'] == 1) {
                    echo 'Ja';
                } else {
                    echo 'Nee';
                }
                echo '</td>';
                echo '<td><a href="functies/deleteBetaalmethode.php?id=' . $row['betaalmethode_id'] . '">Verwijderen</a></td>';
                echo '</tr>';
            }
            ?>
    </div>


</body>

</html>