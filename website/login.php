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
      <link rel="icon" href="images/icon/favicon.png">
</head>

<body>
<div class="loginFormLocatie">
<div class='loginForm'>
    <?php
    include 'connect.php';
    include 'functies/functies.php';
    require 'vendor/autoload.php';
    include 'config.php';
    session_start();

    //NOG TE MAKEN: if the user is already logged in, redirect to the my profile page


    
    if (isset($_POST["login"])) {
        $usernameOrEmail = $_POST["username"];
        $password = $_POST["password"];
    
        $sql = "SELECT * FROM tblklant,tbltypes WHERE klantnaam = ? OR email = ? AND tblklant.type_id = tbltypes.type_id";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row["wachtwoord"])) {
                $_SESSION['klant_id'] = $row['klant_id'];
                $type = $row["type"];
                
                if ($type == "admin") {
                    header("Location: admin");

                } else if ($type == "customer") {
                    header("Location: index");
                }
            }
            
            
    }
    
    echo' <form action="login" method="post">
    <label>Username or Email</label>
    <input type="username"  class="form-control" name="username" required><br>
    <label>Password</label>
    <input type="password"  class="form-control" name="password" required><br>
    <input class="btn btn-primary" type="submit" name="login"><br> <br>
    </form><br><br> ';
    echo '<div class = "error"> The entered password or username is incorrect</div> <br>';
    echo '<div>Dont have an account yet? <a href="register">Register</a></div><br>';
    echo '<div>Forgot your password? <a href="reset_password">Forgot password?</a></div>';
    

    
    }
    
    
    
    else{
        if(isset($_GET['delete'])){
            echo '<div class = "error"> Account deleted Succesfully</div>';
        }
        echo' <form action="login" method="post">
        <label>Username or Email</label>
        <input type="username"  class="form-control" name="username" required><br>
        <label>Password</label>
        <input type="password"  class="form-control" name="password" required><br>
        <input class="btn btn-primary" type="submit" name="login"><br><br>
        </form><br> <br>';
        echo '<div>Dont have an account yet? <a href="register">Register</a></div> <br>';
        echo '<div>Forgot your password? <a href="reset_password">Forgot password?</a></div>';

       
    }
    ?>
<style>
    .google-signin-btn {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        background-color: #f5f5f5;
        color: #4285F4;
        border-radius: 5px;
        text-decoration: none;
        font-family: Arial, sans-serif;
        font-size: 16px;
        border: 1px solid #ddd;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .google-signin-btn img {
        width: 20px;
        height: 20px;
        margin-right: 10px;
    }

    .google-signin-btn:hover {
        background-color: #e0e0e0;
        border-color: #ccc;
    }
</style>
<br>
<?php
echo '
    <a href="' . $client->createAuthUrl() . '" class="google-signin-btn">
        <img src="https://www.svgrepo.com/show/303108/google-icon-logo.svg" alt="Google logo">
        Sign in with Google
    </a>';
?>

    
</div>
</div>


</body>
</html>