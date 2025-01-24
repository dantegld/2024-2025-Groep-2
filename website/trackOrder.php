<?php
include 'connect.php';
include 'functies/functies.php';
session_start();

if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    $error_message = "Order ID is not set or is empty.";
} else {
    $order_id = $_GET['order_id'];
    $status = getOrderStatus($order_id);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order</title>
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
                    <h2>Track Your Order</h2>
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
                    <?php } elseif ($status === 'Unknown') { ?>
                        <p>No orders have been placed yet.</p>
                    <?php } else { ?>
                        <p>Order Number: <?php echo htmlspecialchars($order_id); ?></p>
                        <p>Status: <?php echo htmlspecialchars($status); ?></p>
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
