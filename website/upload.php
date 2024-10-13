<?php
include 'connect.php';
include 'functies/functies.php';
if(isset($_POST["submit"])){
    $image1 = $_FILES['image1'];
    $image2 = $_FILES['image2'];
    $image3 = $_FILES['image3'];
    $merk = $_POST['merk'];
    $naam = $_POST['naam'];
    $kleur1 = $_POST['kleur1'];
    $kleur2 = $_POST['kleur2'];
    $kleur3 = $_POST['kleur3'];
    $categorie = $_POST['categorie'];
    $prijs = $_POST['prijs'];
    $stock = $_POST['stock'];


    $images = ['image1', 'image2', 'image3'];
    $allowed = ['jpg', 'jpeg', 'png', 'avif'];

    foreach ($images as $index => $image) {
        if (!empty($_FILES[$image]['name'])) {
            $fileName = $_FILES[$image]['name'];
            $fileTmpName = $_FILES[$image]['tmp_name'];
            $fileSize = $_FILES[$image]['size'];
            $fileError = $_FILES[$image]['error'];
            $fileType = $_FILES[$image]['type'];

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 100000000) {
                        $kleurVar = 'kleur' . ($index + 1);
                        $fileNameNew = $naam . '_' . $$kleurVar . uniqid('', true) . "." . $fileActualExt;
                        $fileDestination = 'images/shoes/' . $fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);
                        $fileNames[] = $fileDestination;
                    } else {
                        echo "Your file is too big!";
                    }
                } else {
                    echo "There was an error uploading your file!";
                }
            } else {
                echo "You cannot upload files of this type!";
            }
        }
    }


$sql1 = "SELECT * FROM tblmerk WHERE merknaam = ?";
$stmt1 = $mysqli->prepare($sql1);
$stmt1->bind_param("s", $merk);
$stmt1->execute();
$result1 = $stmt1->get_result();
if($result1->num_rows == 0){
    $sql2 = "INSERT INTO tblmerk (merknaam) VALUES (?)";
    $stmt2 = $mysqli->prepare($sql2);
    $stmt2->bind_param("s", $merk);
    $stmt2->execute();
}
$sql4 = "SELECT * FROM tblmerk WHERE merknaam = ?";
$stmt4 = $mysqli->prepare($sql4);
$stmt4->bind_param("s", $merk);
$stmt4->execute();
$result4 = $stmt4->get_result();
$row4 = $result4->fetch_assoc();
$merk_id = $row4['merk_id'];

$sql2 = "SELECT * FROM tblcategorie WHERE categorienaam = ?";
$stmt2 = $mysqli->prepare($sql2);
$stmt2->bind_param("s", $categorie);
$stmt2->execute();
$result2 = $stmt2->get_result();
if($result2->num_rows == 0){
    $sql3 = "INSERT INTO tblcategorie (categorienaam) VALUES (?)";
    $stmt3 = $mysqli->prepare($sql3);
    $stmt3->bind_param("s", $categorie);
    $stmt3->execute();
}
$sql5 = "SELECT * FROM tblcategorie WHERE categorienaam = ?";
$stmt5 = $mysqli->prepare($sql5);
$stmt5->bind_param("s", $categorie);
$stmt5->execute();
$result5 = $stmt5->get_result();
$row5 = $result5->fetch_assoc();
$categorie_id = $row5['categorie_id'];

$sql = "INSERT INTO tblartikels (merk_id, artikelnaam, categorie_id, prijs, stock) VALUES (?, ?, ?, ?, ?)"; 
$stmt = $mysqli->prepare($sql);
$directory = "images/shoes/".$fileNameNew;
$stmt->bind_param("sssss", $merk_id, $naam, $categorie_id, $prijs, $stock);
$stmt->execute();

$sql6 = "SELECT * FROM tblartikels WHERE artikelnaam = ?";
$stmt6 = $mysqli->prepare($sql6);
$stmt6->bind_param("s", $naam);
$stmt6->execute();
$result6 = $stmt6->get_result();
$row6 = $result6->fetch_assoc();
$artikel_id = $row6['artikel_id'];

$variatie_id = 1;
$kleuren = [$kleur1, $kleur2, $kleur3];
foreach ($kleuren as $index => $kleur) {
    if (!empty($kleur)) {
        $fileNameNew = $fileNames[$index]; // Get the corresponding file name
        $sql7 = "INSERT INTO tblvariatie (artikel_id, variatie_id, kleur, directory) VALUES (?, ?, ?, ?)";
        $stmt7 = $mysqli->prepare($sql7);
        $stmt7->bind_param("ssss", $artikel_id, $variatie_id, $kleur, $fileNameNew);
        $stmt7->execute();
        $variatie_id++;
    }
}
}
?>