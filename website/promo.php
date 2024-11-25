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
      <title>PromoCodes</title>
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
      <link rel="stylesheet" href="css/adminpage.css">
   <link rel="icon" href="images/icon/favicon.png">
   
   </head>
<body>

<?php
include 'connect.php';
// check if the user is logged in
session_start();
include 'functies/functies.php';
controleerAdmin();
include 'functies/adminSideMenu.php';
?>

<div class="adminpageCenter">
<?php
if (isset($_POST['add'])) {
    $kortingscode = $_POST['kortingscode'];
    $korting_euro = $_POST['korting_euro'];
    $einddatum = $_POST['einddatum'];

    $stmt = $mysqli->prepare("INSERT INTO tblkortingscodes (kortingscode, korting_euro, einddatum) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $kortingscode, $korting_euro, $einddatum);
    $stmt->execute();
    $stmt->close();
} elseif (isset($_POST['update'])) {
    $kortingscode = $_POST['kortingscode'];
    $korting_euro = $_POST['korting_euro'];
    $einddatum = $_POST['einddatum'];

    $stmt = $mysqli->prepare("UPDATE tblkortingscodes SET korting_euro = ?, einddatum = ? WHERE kortingscode = ?");
    $stmt->bind_param("dss", $korting_euro, $einddatum, $kortingscode);
    $stmt->execute();
    $stmt->close();
} elseif (isset($_POST['delete'])) {
    $kortingscode = $_POST['kortingscode'];

    $stmt = $mysqli->prepare("DELETE FROM tblkortingscodes WHERE kortingscode = ?");
    $stmt->bind_param("s", $kortingscode);
    $stmt->execute();
    $stmt->close();
}

$result = $mysqli->query("SELECT * FROM tblkortingscodes");
?>

<h1>Beheer Kortingscodes</h1>

<form method="POST" action="">
    <h2>Voeg nieuwe kortingscode toe</h2>
    <input type="text" name="kortingscode" placeholder="Kortingscode" required>
    <input type="number" step="0.01" name="korting_euro" placeholder="Korting in Euro" required>
    <input type="date" name="einddatum" placeholder="Einddatum" required>
    <input class= "btn btn-primary" type="submit" name="add" value="Toevoegen">
</form>

<h2>Bestaande kortingscodes</h2>
<table>
    <tr>
        <th>Kortingscode</th>
        <th>Korting in Procent</th>
        <th>Einddatum</th>
        <th>Acties</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <form method="POST" action="">
                <td><input type="text" name="kortingscode" value="<?php echo $row['kortingscode']; ?>" readonly></td>
                <td><input type="number" step="0.01" name="korting_euro" value="<?php echo $row['korting_euro']; ?>" required></td>
                <td><input type="date" name="einddatum" value="<?php echo $row['einddatum']; ?>" required></td>
                <td>
                    <input class= "btn btn-primary" type="submit" name="update" value="Wijzigen">
                    <input class= "btn btn-danger" type="submit" name="delete" value="Verwijderen">
                </td>
            </form>
        </tr>
    <?php } ?>
</table>
</div>
</body>
</html>