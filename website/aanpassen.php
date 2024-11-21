<!DOCTYPE html>
<html lang="en">
<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Manage Stock</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- font awesome -->
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- owl stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Poppins:400,700&display=swap&subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesoeet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <link rel="icon" href="images/icon/favicon.png">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        table {
            width: 90%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 50px auto;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: white;
            font-weight: normal;
        }
        td {
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        input[type="submit"] {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        input:hover {
            background-color: #e60000;
        }
        .message {
            text-align: center;
            font-size: 18px;
            color: #333;
            margin-top: 20px;
        }
        .message.success {
            color: #28a745;
        }
        .message.error {
            color: #dc3545;
        }
        form {
            display: inline;
        }
        .container {
            text-align: center;
            padding: 20px;
        }
        input[type="number"], input[name="artikelnaam"] {
            border: none;
            background-color: transparent;
            text-align: center;
        }
        .price-column {
            width: 50px !important; /* Adjust the width as needed */
        }
        select {
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 5px;
            background-color: #fff;
            color: #333;
        }
    </style>
</head>
<body>
<?php
include 'connect.php';
session_start();
include 'functies/functies.php';
controleerAdmin();
include 'functies/adminSideMenu.php';
?>
<div class="adminpage1">
    <br>
    <h1>Products</h1>
    <br>
    <?php
    if (isset($_POST['aanpassen'])) {
        if (isset($_POST['artikel_id'], $_POST['artikelnaam'], $_POST['prijs'])) {
            $artikel_id = $_POST['artikel_id'];
            $artikelnaam = $_POST['artikelnaam'];
            $prijs = $_POST['prijs'];
            $merk_id = $_POST['merk_id'];
            $categorie_id = $_POST['categorie_id'];
            $updateQuery = "UPDATE tblartikels SET artikelnaam = '$artikelnaam', prijs = '$prijs', merk_id = '$merk_id', categorie_id = '$categorie_id' WHERE artikel_id = '$artikel_id'";
            $updateResult = $mysqli->query($updateQuery);
            if ($updateResult) {
                echo "<div class='message success'>The product with ID $artikel_id has been updated successfully.</div>";
            } else {
                echo "<div class='message error'>An error occurred while updating the product.</div>";
            }
        } else {
            echo "<div class='message error'>Not all data has been provided.</div>";
        }
    }

    if (isset($_POST['delete'])) {
        if (isset($_POST['artikel_id'])) {
            $artikel_id = $_POST['artikel_id'];
            $deleteQuery = "DELETE FROM tblartikels WHERE artikel_id = '$artikel_id'";
            $deleteResult = $mysqli->query($deleteQuery);
            if ($deleteResult) {
                echo "<div class='message success'>The product with ID $artikel_id has been deleted successfully.</div>";
            } else {
                echo "<div class='message error'>An error occurred while deleting the product.</div>";
            }
        } else {
            echo "<div class='message error'>Product ID not provided.</div>";
        }
    }

    $query = "SELECT * FROM tblartikels";
    $result = $mysqli->query($query);
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Product ID</th><th>Product name</th><th class='price-column'>Price</th><th>Brand</th><th>Category</th><th>Action</th><th>Variations</th><th>Delete</th></tr>";
        while ($row = $result->fetch_assoc()) {
            // Fetch all brands
            $brandQuery = "SELECT * FROM tblmerk";
            $brandResult = $mysqli->query($brandQuery);

            // Fetch all categories
            $categoryQuery = "SELECT * FROM tblcategorie";
            $categoryResult = $mysqli->query($categoryQuery);

            echo "<tr>";
            echo "<form method='POST' action='aanpassen.php'>";
            echo "<td>" . $row['artikel_id'] . "</td>";
            echo "<td><input type='text' name='artikelnaam' value='" . $row['artikelnaam'] . "' /></td>";
            echo "<td class='price-column'><input type='number' name='prijs' value='" . $row['prijs'] . "' /></td>";

            // Brand dropdown
            echo "<td><select name='merk_id'>";
            while ($brandRow = $brandResult->fetch_assoc()) {
                $selected = $brandRow['merk_id'] == $row['merk_id'] ? "selected" : "";
                echo "<option value='" . $brandRow['merk_id'] . "' $selected>" . $brandRow['merknaam'] . "</option>";
            }
            echo "</select></td>";

            // Category dropdown
            echo "<td><select name='categorie_id'>";
            while ($categoryRow = $categoryResult->fetch_assoc()) {
                $selected = $categoryRow['categorie_id'] == $row['categorie_id'] ? "selected" : "";
                echo "<option value='" . $categoryRow['categorie_id'] . "' $selected>" . $categoryRow['categorienaam'] . "</option>";
            }
            echo "</select></td>";

            echo "<td>
                      <input type='hidden' name='artikel_id' value='" . $row['artikel_id'] . "' />
                      <input type='submit' name='aanpassen' value='Adjust' />
                  </td>";
            echo "<td><a class='btn btn-primary' href='variaties?artikel_id=" . $row['artikel_id'] . "'>Variations</a></td>";
            echo "<td>
                      <input type='hidden' name='artikel_id' value='" . $row['artikel_id'] . "' />
                      <input type='submit' name='delete' value='Delete' />
                  </td>";
            echo "</form>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No products found.";
    }
    ?>
    <br>
</div>
</body>
</html>