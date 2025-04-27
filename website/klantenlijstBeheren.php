<?php
include 'connect.php';
session_start();

//checkpoint voor onderhoudsmodus
include 'functies/functies.php';
onderhoudsModus($mysqli);
controleerAdmin($mysqli);


    // Display Customer List
    $sql = "SELECT * FROM tblklant";
    $result = $conn->query($sql);
        
    if ($result === false) {
        die("Error executing query: " . $conn->error);
    }
    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Password</th>
                    <th>Shoe Size</th>
                    <th>User Type</th>
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

    // Add, Update, and Delete Customers
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Add

        if (isset($_POST['add'])) {
            $klantnaam = $_POST['klantnaam'];
            $wachtwoord = $_POST['wachtwoord'];
            $schoenmaat = $_POST['schoenmaat'];
            $type = $_POST['type'];
            $sql = "INSERT INTO tblklant (klantnaam, wachtwoord, schoenmaat, type) VALUES ('$klantnaam', '$wachtwoord', '$schoenmaat', '$type')";
            $conn->query($sql);

        } 

        // Update

        elseif (isset($_POST['update'])) {
            $klant_id = $_POST['klant_id'];
            $klantnaam = $_POST['klantnaam'];
            $wachtwoord = $_POST['wachtwoord'];
            $schoenmaat = $_POST['schoenmaat'];
            $type = $_POST['type'];
            $sql = "UPDATE tblklant SET klantnaam='$klantnaam', wachtwoord='$wachtwoord', schoenmaat='$schoenmaat', type='$type' WHERE klant_id='$klant_id'";
            $conn->query($sql);
        }

        // Delete

        elseif (isset($_POST['delete'])) {
            $klant_id = $_POST['klant_id'];
            $sql = "DELETE FROM tblklant WHERE klant_id='$klant_id'";
            $conn->query($sql);
        }
    }


    // Form for Modifications

    echo '<form method="post" action="">
            <h3>Add Customer</h3>
            Customer Name: <input type="text" name="klantnaam"><br>
            Password: <input type="text" name="wachtwoord"><br>
            Shoe Size: <input type="text" name="schoenmaat"><br>
            Type: <input type="text" name="type"><br>
            <input type="submit" name="add" value="Add"><br><br>

            <h3>Update Customer</h3>
            Customer ID: <input type="text" name="klant_id"><br>
            Customer Name: <input type="text" name="klantnaam"><br>
            Password: <input type="text" name="wachtwoord"><br>
            Shoe Size: <input type="text" name="schoenmaat"><br>
            Type: <input type="text" name="type"><br>
            <input type="submit" name="update" value="Update"><br><br>

            <h3>Delete Customer</h3>
            Customer ID: <input type="text" name="klant_id"><br>
            <input type="submit" name="delete" value="Delete"><br><br>
          </form>';

$conn->close();
?>



