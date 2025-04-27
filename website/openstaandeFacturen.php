<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Openstaande Facturen en Betalingen</title>
    <!-- Include your CSS files here -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <link rel="icon" href="images/icon/favicon.png">
</head>

<body>
    <?php
    include 'connect.php';
    session_start();
    include 'functies/functies.php';
    controleerAdmin($mysqli);

    // Handle invoice closing
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['close_invoice'])) {
        $factuur_id = $_POST['factuur_id'];
        sluitFactuur($factuur_id, $mysqli);
        header("Location: openstaandeFacturen.php"); // Refresh the page to show updated status
        exit();
    }

    include 'functies/adminSideMenu.php';

    $sql = "SELECT * FROM tblfacturen WHERE status = 'open'";
    $result = $mysqli->query($sql);
    ?>

    <div class="container">
        <h1>Invoices to pay</h1>
        <div class="tableContainer">
            <table border="1" class="adminTable">
                <tr><th>Invoice ID</th><th>Amount</th><th>Status</th><th>expiration date</th><th>Action</th></tr>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['factuur_id']; ?></td>
                        <td><?php echo $row['bedrag']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['vervaldatum']; ?></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="factuur_id" value="<?php echo $row['factuur_id']; ?>">
                                <input type="submit" name="close_invoice" value="Close Invoice">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <?php
    $result->close();
    $mysqli->close();
    ?>
    <style>
        body {
            display: flex;
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            flex: 1;
            margin-left: 250px; /* Adjust this value based on the width of your side menu */
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .tableContainer {
            width: 100%;
            overflow-x: auto;
            margin-top: 20px;
        }

        .adminTable {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .adminTable th, .adminTable td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .adminTable th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .adminTable tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        .btn-primary {
            background-color: #007BFF;
            border-color: #007BFF;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 2px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</body>

</html>