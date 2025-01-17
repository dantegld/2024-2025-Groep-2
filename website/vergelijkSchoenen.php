<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare Shoes</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="icon" href="images/icon/favicon.png">
    <script src="js/script.js"></script>
</head>
<body>
    <?php
    include 'connect.php';
    session_start();
    include 'functies/functies.php';

    if (isset($_GET['schoen1']) && isset($_GET['schoen2'])) {
        $schoen1 = intval($_GET['schoen1']);
        $schoen2 = intval($_GET['schoen2']);

        $sql = "SELECT * FROM tblartikels WHERE artikel_id IN (?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ii", $schoen1, $schoen2);
        $stmt->execute();
        $result = $stmt->get_result();
        $schoenen = $result->fetch_all(MYSQLI_ASSOC);
    }
    ?>
    <div class="container">
        <h1>Compare Shoes</h1>
        <form method="GET" action="vergelijkSchoenen.php">
            <div class="form-group">
                <label for="schoen1">Shoe 1:</label>
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
                <label for="schoen2">Shoe 2:</label>
                <select name="schoen2" class="form-control" required>
                    <?php
                    $result->data_seek(0); // Reset result pointer
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['artikel_id'] . '">' . $row['artikelnaam'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Compare</button>
        </form>
        <?php if (isset($schoenen) && count($schoenen) == 2): ?>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Attribute</th>
                        <th><?php echo $schoenen[0]['artikelnaam']; ?></th>
                        <th><?php echo $schoenen[1]['artikelnaam']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Price</td>
                        <td>&euro; <?php echo $schoenen[0]['prijs']; ?></td>
                        <td>&euro; <?php echo $schoenen[1]['prijs']; ?></td>
                    </tr>
                    <tr>
                        <td>Brand</td>
                        <td><?php echo getMerkNaam($schoenen[0]['merk_id']); ?></td>
                        <td><?php echo getMerkNaam($schoenen[1]['merk_id']); ?></td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td><?php echo getCategorieNaam($schoenen[0]['categorie_id']); ?></td>
                        <td><?php echo getCategorieNaam($schoenen[1]['categorie_id']); ?></td>
                    </tr>
                    <tr>
                        <td>Viewcount</td>
                        <td><?php echo $schoenen[0]['viewcount']; ?></td>
                        <td><?php echo $schoenen[1]['viewcount']; ?></td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
            <p class="back"><a href="index.php">Back to Home</a></p>
</body>
</html>