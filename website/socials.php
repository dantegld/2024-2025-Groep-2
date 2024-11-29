<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Socials</title>
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
      </style>
    <?php
    include 'connect.php';
    // check if the user is logged in
    session_start();
    include 'functies/functies.php';
    controleerAdmin();
    include 'functies/adminSideMenu.php';
    ?>
    <div class="adminpageCenter">
        <h3>Socials</h3>
            <?php
                echo '
                <table>
            <tr>
                <th>Socials name</th>
                <th>Active</th>
                <th> Activate/Deactivate</th>
            </tr>';
            
                $sql = "SELECT * FROM tblsocialmedia";
                $result = $mysqli->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['socialmedianaam'] . '</td>';
                    echo '<td>';
                    if ($row['beschikbaar'] == 1) {
                        echo 'Yes';
                    } else {
                        echo 'No';
                    }
                    echo '</td>';

                    $socialmedia_id = $row['socialmedia_id'];
                    if ($row['beschikbaar'] == 1) {
                        echo '<td><a href="socialDeactiveren?id=' . $socialmedia_id . '">Deactivate</a></td>';
                    } else {
                        echo '<td><a href="socialActiveren?id=' . $socialmedia_id . '">Activate</a></td>';
                    }
                    echo '</tr>';
                }
                echo '</table>';
                $mysqli->close();
            ?>
    </div>
</body>