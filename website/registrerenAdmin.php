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
      <title>Register</title>
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
include 'functies/adminSideMenu.php';
include 'functies/functies.php';
controleerAdmin();
?>

<div class="adminpage">
<div class="loginFormLocatie">
<div class='loginForm'>
<?php


function displayForm($error = '') {
    echo '<h2>Register</h2>';
    echo '<form action="registrerenAdmin.php" method="post">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required><br>
            <label>Password</label>
            <input type="password" name="password" class="form-control" required><br>
            <label>Email</label>
            <input type="email" name="email" class="form-control" required><br>
            <input class="btn btn-primary" type="submit" name="submit" value="Register"><br>';
    if ($error) {
        echo '<div style="color: red; margin-top: 10px;">' . $error . '</div>';
    }
    echo '</form><br>';
}
function displayForm1($msg = '') {
    echo '<h2>Register</h2>';
    echo '<form action="registrerenAdmin.php" method="post">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required><br>
            <label>Password</label>
            <input type="password" name="password" class="form-control" required><br>
            <label>Email</label>
            <input type="email" name="email" class="form-control" required><br>
            <input class="btn btn-primary" type="submit" name="submit" value="Register"><br>';
    if ($msg) {
        echo '<div style="color: blue; margin-top: 10px;">' . $msg . '</div>';
    }
    echo '</form><br>';
}


// Register form
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $passwordhash = password_hash($password, PASSWORD_DEFAULT);

    // Basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        displayForm('Invalid email format.');
        exit();
    }

    // Check if email domain has MX records
    $domain = substr(strrchr($email, "@"), 1);
    if (!checkdnsrr($domain, "MX")) {
        displayForm('Email domain does not exist.');
        exit();
    }

    // Check if username or email already exists
    $sql = "SELECT * FROM tblklant WHERE klantnaam = ? OR email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username or email already exists
        displayForm('Username or email already exists.');
    } else {
        // Insert new user
        $sql = "INSERT INTO tblklant (klantnaam, wachtwoord, email, type) VALUES (?, ?, ?, 'klant')";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sss", $username, $passwordhash, $email);
        $result = $stmt->execute();

        if ($result) {
            displayForm1('Succes.');
            exit(); // Ensure no further code is executed after the redirect
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
} else {
    displayForm();
}
?>
</div>
</div>

</body>
</html>