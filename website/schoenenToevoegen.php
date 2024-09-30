<?php
include("connect.php");
session_start();
//checkpoint voor onderhoudsmodus
onderhoudsModus();
if($_POST["toevoegen"]) {
    $klant_id = $_POST['klant_id'];
    $artikel_id = $_POST['artikel_id'];
    $aantal = $_POST['aantal'];
$sql = "INSERT INTO tblwinkelwagen (klant_id, artikel_id, aantal) VALUES ('$klant_id', '$artikel_id', '$aantal')";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
} else {
    $sql = "SELECT * FROM tblwinkelwagen";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    echo '
   <td>
                  <form action="schoenenToevoegen.php" method="post" style="display:inline;">
                        <input type="hidden" name="klant_id" value="' . $row['klant_id'] . '">
                        <input type="tekst" name="artikel_id" value="'. $row['artikel_id'] . '" > artikel id<br>
                        <input type="number" name="aantal" value="" > aantal<br>
                        <input type="submit" name="voegtoe" value="toevoegen">
                    </form>
                </td> ';
}
}


?>