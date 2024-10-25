<?php
//ZET DIE DAT JE NIET GEBRUIKT IN COMMENTS

//xamp server
//$mysqli = new mysqli("localhost", "root", "", "groep2");

//ftp server
$mysqli = new mysqli("localhost", "dbgroep2@groep2.", "Groep22024", "groep2"); //connectie maken met de database op ftp server



if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

?>
