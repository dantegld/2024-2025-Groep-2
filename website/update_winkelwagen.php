<?php
include("connect.php");
session_start();

if (isset($_POST["artikel_id"]) && isset($_POST["action"]) && isset($_SESSION["klant_id"])) {
    $artikel_id = $_POST["artikel_id"];
    $klant_id = $_SESSION["klant_id"];
    $action = $_POST["action"];

    // Fetch the current quantity of the product in the cart
    $sql = "SELECT aantal, prijs FROM tblwinkelwagen w JOIN tblartikels a ON w.artikel_id = a.artikel_id WHERE klant_id = '$klant_id' AND w.artikel_id = '$artikel_id'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $aantal = $row["aantal"];
        $prijs_per_item = $row["prijs"];

        // Update quantity based on action
        if ($action == "increase") {
            $aantal++;
        } elseif ($action == "decrease" && $aantal > 1) {
            $aantal--;
        }

        // Update the quantity in the database
        $sql_update = "UPDATE tblwinkelwagen SET aantal = '$aantal' WHERE klant_id = '$klant_id' AND artikel_id = '$artikel_id'";
        $mysqli->query($sql_update);

        // Calculate the new total price for the item and for the entire cart
        $new_total_price = $prijs_per_item * $aantal;

        // Calculate the new total price for the entire cart
        $sql_cart_total = "SELECT SUM(w.aantal * a.prijs) AS total_cart_price 
                           FROM tblwinkelwagen w 
                           JOIN tblartikels a ON w.artikel_id = a.artikel_id 
                           WHERE klant_id = '$klant_id'";
        $cart_total_result = $mysqli->query($sql_cart_total);
        $cart_total_row = $cart_total_result->fetch_assoc();
        $new_total_cart_price = $cart_total_row["total_cart_price"];

        // Return the updated data as JSON
        echo json_encode([
            'new_quantity' => $aantal,
            'new_total_price' => number_format($new_total_price, 2),
            'new_total_cart_price' => number_format($new_total_cart_price, 2)
        ]);
    }
}

$mysqli->close();
?>
