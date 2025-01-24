<?php
include '../connect.php';
include '../functies/functies.php';
session_start();

if (!isset($_SESSION['type']) || $_SESSION['type'] != 'admin') {
    die("Access denied.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id']) && isset($_POST['new_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    updateOrderStatus($order_id, $new_status);
    $message = "Order status updated successfully.";
}

$orders = getAllOrders();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Order Status</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="icon" href="../images/fevicon.png" type="image/gif" />
</head>
<body>
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
                                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                <td><?php echo htmlspecialchars($order['klant_id']); ?></td>
                                <td><?php echo htmlspecialchars($order['status']); ?></td>
                                <td>
                                    <form method="POST" action="">
                                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                        <select name="new_status" class="form-control">
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
</body>
</html>
