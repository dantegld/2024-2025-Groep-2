<?php
include 'connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $schoenmaat = isset($_POST['schoenmaat']) ? intval($_POST['schoenmaat']) : 0;

    if ($id > 0 && $schoenmaat > 0 && isset($_SESSION["klant_id"])) {
        $sql = "UPDATE tblwinkelwagen SET schoenmaat = ? WHERE id = ? AND klant_id = ?";
        $stmt = $mysqli->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("iii", $schoenmaat, $id, $_SESSION["klant_id"]);

            if ($stmt->execute()) {
                echo "Schoenmaat updated successfully";
            } else {
                echo "Error updating schoenmaat: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error preparing statement: " . $mysqli->error;
        }
    } else {
        echo "Invalid input or session data";
    }
} else {
    echo "Invalid request method";
}

$mysqli->close();
?>