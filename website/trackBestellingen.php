<?php
include 'connect.php';
include 'functies/functies.php';
session_start();

if (!isset($_SESSION['klant_id'])) {
    $error_message = "You need to log in to view your orders.";
} else {
    $klant_id = $_SESSION['klant_id'];
    $orders = getBestellingenKlant($klant_id);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Orders</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2>Track Your Orders</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <?php if (isset($error_message)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($error_message); ?>
                        </div>
                    <?php } elseif (empty($orders)) { ?>
                        <p>No orders have been placed yet.</p>
                    <?php } else { ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Order Number</th>
                                    <th>Status</th>
                                    <th>Delivery Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($order['bestelling_id']); ?></td>
                                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                                        <td><?php echo htmlspecialchars($order['leveringsdatum']); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="index.php" class="btn btn-primary">Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>
