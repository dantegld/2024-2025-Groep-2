<?php
include 'connect.php';

if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $sql = "UPDATE tblklant SET mail = 0 WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    if ($stmt->execute()) {
        echo "Je bent succesvol uitgeschreven van de e-mails.";
    } else {
        echo "Er is een probleem opgetreden bij het uitschrijven.";
    }
    $stmt->close();
    $mysqli->close(); // Close the MySQL connection
} else {
    echo "Geen e-mailadres opgegeven.";
    $mysqli->close(); // Close the MySQL connection
}
?>