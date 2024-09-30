<!DOCTYPE html>
<html lang="en">
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
      <title>Log-in</title>
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
   <link rel="icon" href="images/ico.png">
</head>

<body>
<div class='loginForm'>
    <?php
    include 'connect.php';
    session_start();

    //checkpoint voor onderhoudsmodus
    onderhoudsModus();

    
    if (isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
    
        $sql="SELECT * FROM tblklant";
        $result = $mysqli->query($sql);
        
    
        while ($row = $result->fetch_assoc()) {
            if($password==$row["wachtwoord"]&&$username==$row["klantnaam"]){
                $_SESSION['klant_id']= $row['klant_id'];
                $sql1= "SELECT type from tblklant where klantnaam='".$username."' AND wachtwoord='".$password."'";
                print $sql1;
                $result1= $mysqli->query($sql1);
                while ($row1 = $result1->fetch_assoc()) {
                    echo "<br>";
                    $type=$row1["gebruikerstype"];
                    echo $type;
                    echo "<br>";
                }
                if($type=="admin"){
                    $_SESSION["admin"]=true;
                    $_SESSION["klant"]=true;
                    $_SESSION["eigenaar"]=false;    
                   //header("Location: ?.php");                  
                   
                }
                else if($type=="klant"){
                    $_SESSION["klant"]=true;
                    $_SESSION["admin"]=false;
                    $_SESSION["eigenaar"]=false;
                    //header("Location: ?.php");
                }
                else if ($type=="eigenaar"){
                    $_SESSION["eigenaar"]=true;
                    $_SESSION["klant"]=true;
                    $_SESSION["admin"]=true;
                    //header("Location: ?.php");
                }
                else{
                    echo"error";
                    
    
                }
            }
            
            
    }
    
    echo' <form action="login.php" method="post">
    <label>username</label>
    <input type="username" name="username">
    <label>password</label>
    <input type="password" name="password">
    <input type="submit" name="login">
    </form>';
    echo "<div class = error> ERROR: Foute Gegevens";
    echo "</div>";
    echo '<div><a href="register.php">Nog geen account? Register</a></div>';

    
    }
    
    
    
    else{
        echo' <form action="login.php" method="post">
        <label>username</label>
        <input type="username" name="username">
        <label>password</label>
        <input type="password" name="password">
        <input type="submit" name="login">
        </form>';
        echo '<div><a href="register.php">Nog geen account? Register</a></div>';
    }
    
    
    ?>
</div>
</body>
</html>