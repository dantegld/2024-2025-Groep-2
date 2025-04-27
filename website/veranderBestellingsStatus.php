<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Order Status</title>
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
    include 'functies/functies.php';
    session_start();
    controleerAdmin();
    include 'functies/adminSideMenu.php';

    if (!isset($_SESSION['type']) || $_SESSION['type'] != 'admin') {
        die("Access denied.");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bestelling_id']) && isset($_POST['nieuw_status'])) {
        $bestelling_id = $_POST['bestelling_id'];
        $nieuw_status = $_POST['nieuw_status'];
        updateBestellingStatus($bestelling_id, $nieuw_status);
        $message = "Order status updated successfully.";
    }

    $orders = getAlleBestellingen();
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2>Change Order Status</h2>
                </div>
            </div>
        </div>
        <?php if (isset($message)) { ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer ID</th>
                            <th>Status</th>
                            <th>Change Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['bestelling_id']); ?></td>
                                <td><?php echo $order['klant_id'] ? htmlspecialchars($order['klant_id']) : 'guest'; ?></td>
                                <td><?php echo htmlspecialchars($order['status']); ?></td>
                                <td>
                                    <form method="POST" action="">
                                        <input type="hidden" name="bestelling_id" value="<?php echo htmlspecialchars($order['bestelling_id']); ?>">
                                        <select name="nieuw_status" class="form-control">
                                            <option value="Processing">Processing</option>
                                            <option value="Underway">Underway</option>
                                            <option value="Delivered">Delivered</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary mt-2">Update Status</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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

        .table {
            width: 100%;
            margin-top: 20px;
        }

        .table th, .table td {
            text-align: left;
            padding: 8px;
        }

        .table th {
            background-color: #f2f2f2;
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