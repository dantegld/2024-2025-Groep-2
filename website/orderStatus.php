<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Admin Page</title>
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
    session_start();
    include 'functies/functies.php';
    controleerAdmin();
    include 'functies/adminSideMenu.php';
    
    
    if (isset($_POST['submit'])) {
        $status = $_POST['status'];
        $verkoop_id = $_POST['verkoop_id'];
        $sql = "UPDATE tblaankoop SET status = '$status' WHERE verkoop_id = '$verkoop_id'";
        $mysqli->query($sql);
    }


    //table with all orders from tblaankop with klant id and klant name from tblklant
    $sql = "SELECT * FROM tblaankoop INNER JOIN tblklant ON tblaankoop.klant_id = tblklant.klant_id";
    $result = $mysqli->query($sql);

    echo '<div class="tableContainer"><table border="1" class="adminTable">'
    . '<tr>'
    . '<th>Order ID</th>'
    . '<th>Customer ID</th>'
    . '<th>Customer Name</th>'
    . '<th>Order Date</th>'
    . '<th>Order Status</th>'
    . '<th>Change Status</th>';
    echo '</tr>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>'
        . '<td>' . $row['verkoop_id'] . '</td>'
        . '<td>' . $row['klant_id'] . '</td>'
        . '<td>' . $row['klantnaam'] . '</td>'
        . '<td>' . $row['ontvangstdatum'] . '</td>'
        . '<td>' . $row['status'] . '</td>'
        . '<td><form action="orderStatus.php" method="post">'
        . '<input type="hidden" name="verkoop_id" value="' . $row['verkoop_id'] . '">'
        . '<select name="status">'
        . '<option value="verwerkt">Verwerkt</option>'
        . '<option value="verzonden">Verzonden</option>'
        . '<option value="afgeleverd">Afgeleverd</option>'
        . '</select><br>'
        . '<input type="submit" name="submit" value="Change Status">';
        if ($row['status'] == 'afgeleverd') {
            echo '<button><a href="notificateklant.php?verkoop_id=' . $row['verkoop_id'] . '">Notificate Customer</a></button>';
        }
        echo '</form></td>'
        . '</tr>';
    }
    echo '</table>';
    $result->close();
    ?>