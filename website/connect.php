<?php
$mysqli = new mysqli("auth-db1650.hstgr.io", "u578783310_groep2", "Groep22024", "u578783310_myshoes");
//$mysqli = new mysqli("localhost", "root", "", "u578783310_myshoes");



if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

?>
