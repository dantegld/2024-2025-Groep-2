<?php
include 'connect.php';
session_start();

//checkpoint voor onderhoudsmodus
include 'functies/functies.php';
onderhoudsModus();
controleerAdmin();


    //Klantenlijst weergeven
    $sql = "SELECT * FROM tblklant";
    $result = $conn->query($sql);
        
    if ($result === false) {
        die("Error executing query: " . $conn->error);
    }
    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Klant ID</th>
                    <th>Klantnaam</th>
                    <th>Wachtwoord</th>
                    <th>Schoenmaat</th>
                    <th>Gebruiker Type</th>
                </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["klant_id"] . "</td>
                    <td>" . $row["klantnaam"] . "</td>
                    <td>" . $row["wachtwoord"] . "</td>
                    <td>" . $row["schoenmaat"] . "</td>
                    <td>" . $row["type"] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

    // Toevoegen, bijwerken en verwijderen van klanten
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //toevoegen

        if (isset($_POST['add'])) {
            $klantnaam = $_POST['klantnaam'];
            $wachtwoord = $_POST['wachtwoord'];
            $schoenmaat = $_POST['schoenmaat'];
            $type = $_POST['type'];
            $sql = "INSERT INTO tblklant (klantnaam, wachtwoord, schoenmaat, type) VALUES ('$klantnaam', '$wachtwoord', '$schoenmaat', '$type')";
            $conn->query($sql);

        } 

        //wijzigen

        elseif (isset($_POST['update'])) {
            $klant_id = $_POST['klant_id'];
            $klantnaam = $_POST['klantnaam'];
            $wachtwoord = $_POST['wachtwoord'];
            $schoenmaat = $_POST['schoenmaat'];
            $type = $_POST['type'];
            $sql = "UPDATE tblklant SET klantnaam='$klantnaam', wachtwoord='$wachtwoord', schoenmaat='$schoenmaat', type='$type' WHERE klant_id='$klant_id'";
            $conn->query($sql);
        }

        //verwijderen

        elseif (isset($_POST['delete'])) {
            $klant_id = $_POST['klant_id'];
            $sql = "DELETE FROM tblklant WHERE klant_id='$klant_id'";
            $conn->query($sql);
        }
    }


    // Form voor wijzijgingen

    echo '<form method="post" action="">
            <h3>Klant toevoegen</h3>
            Klantnaam: <input type="text" name="klantnaam"><br>
            Wachtwoord: <input type="text" name="wachtwoord"><br>
            Schoenmaat: <input type="text" name="schoenmaat"><br>
            Type: <input type="text" name="type"><br>
            <input type="submit" name="add" value="Toevoegen"><br><br>

            <h3>Klant bijwerken</h3>
            Klant ID: <input type="text" name="klant_id"><br>
            Klantnaam: <input type="text" name="klantnaam"><br>
            Wachtwoord: <input type="text" name="wachtwoord"><br>
            Schoenmaat: <input type="text" name="schoenmaat"><br>
            Type: <input type="text" name="type"><br>
            <input type="submit" name="update" value="Bijwerken"><br><br>

            <h3>Klant verwijderen</h3>
            Klant ID: <input type="text" name="klant_id"><br>
            <input type="submit" name="delete" value="Verwijderen"><br><br>
          </form>';

?>



