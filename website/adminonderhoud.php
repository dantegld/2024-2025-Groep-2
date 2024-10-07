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
    ?>

    <!-- side menu -->
    <div class="sidemenu">
                        <a href="index.php">Home</a>
                        <a href="admin.php">Admin Pagina</a>
                        <a href="adminonderhoud.php">Onderhoudsmodus</a>
                    </div>
    
    <div class="adminpage">
    <h2 class="titel1">Onderhoudsmodus</h2><br>
    <?php
    //knop that turns on the maintenance mode

    $sql1 = "SELECT * FROM tbladmin WHERE functienaam = 'onderhoudmodus' and functiewaarde = 1";
    $result1 = $mysqli->query($sql1);
    if ($result1->num_rows > 0) {
        echo "Onderhoudsmodus is aan<br>";
            echo "<form action='adminonderhoud.php' method='post'>
        <input type='submit' name='off' value='Zet onderhoudsmodus uit'><br>
            </form>";

    } else {
        echo "Onderhoudsmodus is uit<br>";
        echo "<form action='adminonderhoud.php' method='post'>
        <input type='submit' name='on' value='Zet onderhoudsmodus aan'><br>
            </form>";
    }

    // check if the form is submitted

    if (isset($_POST['on'])) {
        $sql = "UPDATE tbladmin SET functiewaarde = 1 WHERE functienaam = 'onderhoudmodus'";
        $result = $mysqli->query($sql);
        if ($result) {
            header("Refresh: 1; url=adminonderhoud.php");
        } else {
            echo "Failed to turn on maintenance mode";
        }
    } elseif (isset($_POST['off'])) {
        $sql = "UPDATE tbladmin SET functiewaarde = 0 WHERE functienaam = 'onderhoudmodus'";
        $result = $mysqli->query($sql);
        if ($result) {
            header("Refresh: 1; url=adminonderhoud.php");
        } else {
            echo "Failed to turn off maintenance mode";
        }
    }



    ?>
    </div>
</body>

</html>