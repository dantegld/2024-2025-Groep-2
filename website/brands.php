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
    ?>
    <div class="adminpageCenter">
        <?php
        if (isset($_GET["deleteid"])) {
            $deleteid = $_GET["deleteid"];
            $sql = "DELETE FROM tblmerk WHERE merk_id = $deleteid";
            if ($mysqli->query($sql) === TRUE) {
                header("Refresh:0; url=brands");
            } else {
                echo "Error deleting record: " . $mysqli->error;
            }
        }
        if(isset($_GET["editid"])){
            $editid = $_GET["editid"];
            $sql = "SELECT * FROM tblmerk WHERE merk_id = $editid";
            $result = $mysqli->query($sql);
            $row = $result->fetch_assoc();
            echo '<form action="brands.php" method="post">
            <input type="hidden" name="editid" value="'.$editid.'">
            <input type="text" name="brand" value="'.$row['merknaam'].'">
            <input type="submit" name="submitedit" value="Edit">
            </form>';
        }
        if(isset($_GET["addID"])){
            echo '<form action="brands.php" method="post">
            <input type="text" name="brand" placeholder="brand">
            <input type="submit" name="submitadd" value="Add">
            </form>';
        }
        if(isset($_POST["submitadd"])){
            $brand = $_POST["brand"];
            $sql = "INSERT INTO tblmerk (merknaam) VALUES ('$brand')";
            if ($mysqli->query($sql) === TRUE) {
                header("Refresh:0; url=brands");
            } else {
                echo "Error: " . $sql . "<br>" . $mysqli->error;
            }
        }
        if(isset($_POST["submitedit"])){
            $editid = $_POST["editid"];
            $brand = $_POST["brand"];
            $sql = "UPDATE tblmerk SET merknaam = '$brand' WHERE merk_id = $editid";
            if ($mysqli->query($sql) === TRUE) {
                header("Refresh:0; url=brands");
            } else {
                echo "Error updating record: " . $mysqli->error;
            }
        }
        if((!(isset($_GET["editid"]))) && (!(isset($_GET["deleteid"]))) && (!(isset($_GET["addID"])))
        && (!(isset($_POST["submitedit"]))) && (!(isset($_POST["submitadd"])))){
            $sql = "SELECT * FROM tblmerk";
            $result = $mysqli->query($sql);
            //table
            echo '<table class="adminTable">
            <thead>
                <tr>
                    <th scope="col">Brand ID</th>
                    <th scope="col">Brand</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                <td>' . $row['merk_id'] . '</td>
                <td>' . $row['merknaam'] . '</td>
                <td><a href="brands?editid=' . $row['merk_id'] . '">Edit</a></td>
                <td><a href="brands?deleteid=' . $row['merk_id'] . '">Delete</a></td>
                </tr>';
            }
            echo '</tbody>
            </table>';
            echo '<a href="brands?addID=' . true .'">add new brand</a>';

        }






        $mysqli->close();
        ?>
    </div>
</body>
</html>