<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="loginFormLocatie">
    <div class='loginForm'>
        <?php
        include 'connect.php';
        session_start();

        function displayForm($error = '') {
            echo '<h2>Register</h2>';
            echo '<form action="register" method="post">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required><br>
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required><br>
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required><br>
                    <input class="btn btn-primary" type="submit" name="submit" value="Register"><br>';
            if ($error) {
                echo '<div class="alreadyExists" style="color: red; margin-top: 10px;">' . $error . '</div>';
            }
            echo '</form><br>';
            echo '<div>Al een account? <a href="login">Log in</a></div>';
        }

        // Register form
        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            // Check if username or email already exists
            $stmt = $mysqli->prepare("SELECT * FROM tblklant WHERE klantnaam = ? OR email = ?");
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                displayForm("Gebruikersnaam of email bestaat al.");
            } else {
                // Insert new user with type 'klant'
                $sql = "INSERT INTO tblklant (klantnaam, wachtwoord, email, type_id) VALUES (?, ?, ?, '2')";
                $stmt = $mysqli->prepare($sql);
                $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT), $email]);
                $id = $mysqli->insert_id;
                $stmt->close();
                $sqlType = "INSERT INTO tbltypes (type_id, type) VALUES (?, 'customer')";
                $stmtType = $mysqli->prepare($sqlType);
                $stmtType->execute([$id]);
                $stmtType->close();

                echo '<h2>Registratie succesvol!</h2>';
                echo '<div>Ga terug naar de <a href="login">loginpagina</a>.</div>';
            }
        } else {
            displayForm();
        }
        ?>
    </div>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
