<?php
include 'connect.php';
session_start();
include 'functies/functies.php';
controleerAdmin($mysqli);

// Handle loyalty points update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_points'])) {
    $klant_id = $_POST['klant_id'];
    $loyalty_points = $_POST['loyalty_points'];
    $updateSql = "UPDATE tblklant SET klantloyaliteitsPunten = ? WHERE klant_id = ?";
    $stmt = $mysqli->prepare($updateSql);
    $stmt->bind_param("ii", $loyalty_points, $klant_id);
    $stmt->execute();
    $stmt->close();
    header("Location: klantLoyaliteit.php"); // Refresh the page to show updated points
    exit();
}

include 'functies/adminSideMenu.php';

// Fetch all customers and their CLV
$sql = "SELECT k.klant_id, k.klantnaam, k.email, k.schoenmaat, k.klantloyaliteitsPunten, t.type, SUM(a.totaalbedrag) AS total_spent
        FROM tblklant k
        LEFT JOIN tblaankoop a ON k.klant_id = a.klant_id
        JOIN tbltypes t ON k.type_id = t.type_id
        GROUP BY k.klant_id";
$result = $mysqli->query($sql);

// Fetch total number of customers
$totalCustomersSql = "SELECT COUNT(*) AS total_customers FROM tblklant";
$totalCustomersResult = $mysqli->query($totalCustomersSql);
$totalCustomersRow = $totalCustomersResult->fetch_assoc();
$totalCustomers = $totalCustomersRow['total_customers'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Loyalty Management</title>
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
    <div class="container">
        <h1>Customer Loyalty Management</h1>
        <p>Total Number of Customers: <?php echo $totalCustomers; ?></p>
        <table border="1" class="adminTable">
            <tr><th>Customer ID</th><th>Name</th><th>Email</th><th>Shoe Size</th><th>Type</th><th>Total Spent</th><th>Loyalty Rating</th><th>Action</th></tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['klant_id']; ?></td>
                    <td><?php echo $row['klantnaam']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['schoenmaat']; ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <td>€<?php echo number_format(berekenKlantLevenswaarde($row['klant_id']), 2); ?></td>
                    <td><?php echo $row['klantloyaliteitsPunten']; ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="klant_id" value="<?php echo $row['klant_id']; ?>">
                            <input type="number" name="loyalty_points" value="<?php echo $row['klantloyaliteitsPunten']; ?>" min="0" max="5" step="1">
                            <input type="submit" name="update_points" value="Update Rating">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>

<?php $mysqli->close(); ?>

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

    form {
        display: flex;
        align-items: center;
    }

    input[type="number"] {
        width: 60px;
        margin-right: 10px;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>
