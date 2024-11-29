<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vergelijk Schoenen</title>
    <!-- Include necessary CSS and JS files -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="icon" href="images/icon/favicon.png">
</head>
<body>
    <?php
    include 'connect.php';
    session_start();
    include 'functies/functies.php';
    onderhoudsModus();
    ?>
    <div class="container">
        <h1>Vergelijk Schoenen</h1>
        <form method="GET" action="vergelijkSchoenen.php">
            <div class="form-group">
                <label for="schoen1">Schoen 1:</label>
                <select name="schoen1" class="form-control" required>
                    <?php
                    $sql = "SELECT artikel_id, artikelnaam FROM tblartikels";
                    $result = $mysqli->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['artikel_id'] . '">' . $row['artikelnaam'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="schoen2">Schoen 2:</label>
                <select name="schoen2" class="form-control" required>
                    <?php
                    $result->data_seek(0); // Reset result pointer
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['artikel_id'] . '">' . $row['artikelnaam'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Vergelijk</button>
        </form>
        <?php
        if (isset($_GET['schoen1']) && isset($_GET['schoen2'])) {
            $schoen1 = $_GET['schoen1'];
            $schoen2 = $_GET['schoen2'];

            $schoenen = getSchoenenVergelijking($schoen1, $schoen2);

            if (count($schoenen) == 2) {
                echo '<table class="table table-bordered">';
                echo '<thead><tr><th>Eigenschap</th><th>' . $schoenen[0]['artikelnaam'] . '</th><th>' . $schoenen[1]['artikelnaam'] . '</th></tr></thead>';
                echo '<tbody>';
                echo '<tr><td>Prijs</td><td>&euro; ' . $schoenen[0]['prijs'] . '</td><td>&euro; ' . $schoenen[1]['prijs'] . '</td></tr>';
                echo '<tr><td>Merk</td><td>' . getMerkNaam($schoenen[0]['merk_id']) . '</td><td>' . getMerkNaam($schoenen[1]['merk_id']) . '</td></tr>';
                echo '<tr><td>Categorie</td><td>' . getCategorieNaam($schoenen[0]['categorie_id']) . '</td><td>' . getCategorieNaam($schoenen[1]['categorie_id']) . '</td></tr>';
                echo '<tr><td>Viewcount</td><td>' . $schoenen[0]['viewcount'] . '</td><td>' . $schoenen[1]['viewcount'] . '</td></tr>';
                echo '</tbody>';
                echo '</table>';
            }
        }
        ?>
    </div>
</body>
</html>