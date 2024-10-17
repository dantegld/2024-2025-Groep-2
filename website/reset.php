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
if($_SERVER ['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $uniekwoord = $_POST['uniekwoord'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM tblklant WHERE email = ? AND uniekwoord = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ss', $email, $uniekwoord);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $sql = "UPDATE tblklant SET wachtwoord = ? WHERE klant_id = ?";
        $stmt = $mysqli->prepare($sql);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param('si', $hashed_password, $row['klant_id']);
        $stmt->execute();
        echo '<h2>Wachtwoord succesvol gereset!</h2>';
        echo '<div>Ga terug naar de <a href="login.php">loginpagina</a>.</div>';
    } else {

        echo '<h2>Wachtwoord resetten</h2>';
    
        echo '<form action="reset.php" method="post">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required><br>
                <label>Uniek woord</label>
                <input type="text" name="uniekwoord" class="form-control" required><br>
                <label>Nieuw wachtwoord</label>
                <input type="password" name="password" class="form-control" required><br>';
                echo '<div style="color: red;">Resetten is mislukt.</div> <br>';
                echo '<input class="btn btn-primary" type="submit" name="submit" value="Reset wachtwoord"><br>';
    }
} else {
    echo '<h2>Wachtwoord resetten</h2>';
    echo '<form action="reset.php" method="post">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required><br>
            <label>Uniek woord</label>
            <input type="text" name="uniekwoord" class="form-control" required><br>
            <label>Nieuw wachtwoord</label>
            <input type="password" name="password" class="form-control" required><br>
            <input class="btn btn-primary" type="submit" name="submit" value="Reset wachtwoord"><br>';
}


?>

</body>
</html>