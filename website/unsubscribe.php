<?php
include 'connect.php';

if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $sql = "UPDATE tblklant SET mail = 0 WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    if ($stmt->execute()) {
        echo "You succesfully unsubscribed.";
    } else {
        echo "Something went wrong.";
    }
    $stmt->close();
    $mysqli->close(); // Close the MySQL connection
} else {
    echo "No email.";
    $mysqli->close(); // Close the MySQL connection
}
?>