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
      <!--  -->
      <!-- owl stylesheets -->
      <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Poppins:400,700&display=swap&subset=latin-ext" rel="stylesheet">
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesoeet" href="css/owl.theme.default.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
   <link rel="icon" href="images/icon/favicon.png">
   </head>
      <style>
         body {
             font-family: 'Poppins', sans-serif;
             background-color: #f5f5f5;
             margin: 0;
             padding: 0;
            }
             h1{
                text-align: center;
                margin-top: 20px;
             }
         table {
            width: 60%;
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
         input[type="number"],input[name="artikelnaam"] {
             border: none;
             background-color: transparent;
             text-align: center;
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
<div class="adminpage">
    <br>
    <h1>Products</h1>
    <br>
    <?php
 
 if (isset($_POST['aanpassen'])) {
    if (isset($_POST['artikel_id'], $_POST['artikelnaam'], $_POST['prijs'])) {
        $artikel_id = $_POST['artikel_id'];
        $artikelnaam = $_POST['artikelnaam'];
        $prijs = $_POST['prijs'];
        $updateQuery = "UPDATE tblartikels SET artikelnaam = '$artikelnaam', prijs = '$prijs' WHERE artikel_id = '$artikel_id'";
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
    $artikel_id = $_POST['artikel_id'];
    $deleteQuery1 = "DELETE FROM tblartikels WHERE artikel_id = '". $artikel_id ."'";
    $deleteResult1 = $mysqli->query($deleteQuery1);
    $sql2 = "DELETE FROM tblvariatie WHERE artikel_id = '". $artikel_id ."'";
    $result2 = $mysqli->query($sql2);
}

    $query = "SELECT * FROM tblartikels";
    $result = $mysqli->query($query);
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Poduct ID</th><th>Product name</th><th>Price</th><th>Action</th><th>Variations</th><th>Delete</th></tr>";
        while ($row = $result->fetch_assoc()) {

            echo "<tr>";
            echo "<form method='POST' action='aanpassen.php'>";
            echo "<td>" . $row['artikel_id'] . "</td>";
            echo "<td><input type='text' name='artikelnaam' value='" . $row['artikelnaam'] . "' /></td>";
            echo "<td><input type='number' name='prijs' value='" . $row['prijs'] . "' /></td>";
            echo "<td>
                      <input type='hidden' name='artikel_id' value='" . $row['artikel_id'] . "' />
                      <input type='submit' name='aanpassen' value='Adjust' />
                  </td>";
            echo "<td><a class='btn btn-primary' href='variaties.php?artikel_id=" . $row['artikel_id'] . "'>Variations</a></td>";
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
    // Handle form submission
    if (isset($_POST['aanpassen'])) {
        // Ensure the keys exist in the POST array before accessing them
        if (isset($_POST['artikel_id'], $_POST['artikelnaam'], $_POST['prijs'])) {
            $artikel_id = $_POST['artikel_id'];
            $artikelnaam = $_POST['artikelnaam'];
            $prijs = $_POST['prijs'];
            $updateQuery = "UPDATE tblartikels SET artikelnaam = '$artikelnaam', prijs = '$prijs' WHERE artikel_id = '$artikel_id'";
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
    ?>
    <br>
</div>
   </body>
</html>