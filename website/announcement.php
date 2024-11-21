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
    <title>announcement</title>
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
        $announcement = $_POST['announcement'];
        $sql = "UPDATE tblannouncement SET announcement = '$announcement' WHERE announcement_id = 0";
        $result = $mysqli->query($sql);
        echo '<div class="alert alert-success" role="alert">Announcement has been updated</div>';
        print("<script>
            setTimeout(function(){
                window.location = 'announcement.php';
            }, 5000);
        </script>");

    } else if (isset($_POST['submit_zero'])) {
        $announcement = $_POST['announcement'];
        $sql = "INSERT INTO tblannouncement (announcement) VALUES ('$announcement')";
        $result = $mysqli->query($sql);
        echo '<div class="alert alert-success" role="alert">Announcement has been added</div>';
        print("<script>
            setTimeout(function(){
                window.location = 'announcement.php';
            }, 5000);
        </script>");

    } else if (isset($_POST['delete'])) {
        $sql = "DELETE FROM tblannouncement WHERE announcement_id = 0";
        $result = $mysqli->query($sql);
        echo '<div class="alert alert-danger" role="alert">Announcement has been deleted</div>';
        print("<script>
            setTimeout(function(){
                window.location = 'announcement.php';
            }, 5000);
        </script>");

    } else {
        echo '<h1>Announcement</h1>';
        $sql = "SELECT * FROM tblannouncement";
        $result = $mysqli->query($sql);

        if ($result->num_rows == 0) {
            echo '
            <form method="post" action="announcement.php">
            <label for="announcement">Announcement text:</label>
            <textarea name="announcement" class="form-control" rows="10" value="announcement" ></textarea><br>
            <input type="submit" name="submit_zero" value="Submit" class="btn btn-primary">
            <input type="submit" name="delete" value="Delete" class="btn btn-danger">';
       
        } else {
            while ($row = $result->fetch_assoc()) {
            echo 
            '<form method="post" action="announcement.php">
            <label for="announcement">Announcement text updaten:</label>
            <textarea name="announcement" class="form-control" rows="10">' . $row['announcement'] . '</textarea><br>
            <input type="submit" name="submit" value="Update" class="btn btn-primary">
            <input type="submit" name="delete" value="Delete" class="btn btn-danger">
            </form>';
            }
        }
    }

    ?>
</body>