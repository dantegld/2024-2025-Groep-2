<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- basic meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title>Reset Password</title>
    <!-- bootstrap and stylesheets -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="images/icon/favicon.png">
</head>
<body>
<div class="loginFormLocatie">
    <div class="loginForm">
        <?php
        include 'connect.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $uniekwoord = $_POST['uniekwoord'];
            $password = $_POST['password'];

            // Fetch the unique word hash and check if the email exists
            $sql = "SELECT * FROM tblklant WHERE email = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Verify the unique word hash
                if (password_verify($uniekwoord, $row['uniekwoord'])) {
                    // Hash the new password and update it
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "UPDATE tblklant SET wachtwoord = ? WHERE klant_id = ?";
                    $stmt = $mysqli->prepare($sql);
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
                    echo '<div style="color: red;">Het unieke woord is onjuist. Probeer opnieuw.</div> <br>';
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
                        <input type="password" name="password" class="form-control" required><br>';
                echo '<div style="color: red;">Geen account gevonden met dit emailadres.</div> <br>';
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
    </div>
</div>
</body>
</html>
