<?php
session_start();
// Include config file
require_once 'config.php';
if ( isset( $_POST['submit'] ) ) {
    $owner = $_SESSION['userID'];
    $propname = $_POST["propname"];
    $street = $_POST["street"];
    $city = $_POST["city"];
    $zip = $_POST["zip"];
    $acres = $_POST["acres"];
    $propType = $_POST["propType"];
    $animal = $_POST["animal"];
    $allCrops = $_POST["allCrops"];
    $garden = $_POST["garden"];
    $orchard = $_POST["orchard"];
    $public = $_POST["public"];
    $commercial = $_POST["commercial"];
    $success = "Property successfully created.";
    $failure = "The following went wrong:";
    $f3 = "   Property name was not unique";

    $checkProperty = "SELECT * FROM Property Where Name = '$propname'";
    $r3 = $conn->query($checkProperty);

    if ($r3->num_rows > 0) {
        $failure .= $f3;
    }

    if ($r3->num_rows >0 ) {
        echo "<script type='text/javascript'>alert('$failure');</script>";
        echo "<script>window.location = 'ownerAdd.php'</script>";
    } else {
        if ($propType == "1") {
            $propType = "ORCHARD";
        } elseif($propType == "2") {
            $propType = "FARM";
        } else {
            $propType = "GARDEN";
        }
        $getMaxID = "SELECT MAX(ID) AS 'ID' FROM Property";
        $idValue = $conn->query($getMaxID);
        $row = mysqli_fetch_array($idValue);
        $idValue = $row['ID'];
        $idValue++;
        if ($commercial == "1") {
            $commercial = 1;
        } else {
            $commercial = 0;
        }
        if ($public == "1") {
            $public = 1;
        } else {
            $public = 0;
        }
        $createProperty = "INSERT INTO  `cs4400_team_1`.`Property` (`ID` ,`Name` ,`Size` ,`IsCommercial` ,`IsPublic` ,`Street` ,`City` ,`Zip` ,`PropertyType` ,`Owner` ,`ApprovedBy`)
        VALUES ('$idValue',  '$propname',  '$acres',  '$commercial',  '$public',  '$street',  '$city',  '$zip',  '$propType',  '$owner',  NULL)";
        $conn->query($createProperty);
        $desiredAnimal = "";
        $desiredCrop = "";
        if ($propType == "FARM") {
            $desiredAnimal = $animal;
            $desiredCrop = $allCrops;
        } elseif ($propType == "ORCHARD") {
            $desiredCrop = $orchard;
        } else {
            $desiredCrop = $garden;
        }
        //Now we need to insert the crop
        $createHasCrop = "INSERT INTO  `cs4400_team_1`.`Has` (`PropertyID` ,`ItemName`)
        VALUES ('$idValue',  '$desiredCrop')";
        $conn->query($createHasCrop);
        if ($desiredAnimal != "") {
            $createHasAnimal = "INSERT INTO  `cs4400_team_1`.`Has` (`PropertyID` ,`ItemName`)
            VALUES ('$idValue',  '$desiredAnimal')";
            $conn->query($createHasAnimal);
        }

        echo "<script type='text/javascript'>alert('$success');</script>";
        echo "<script>window.location = 'ownerHome.php'</script>";
    }
    $conn ->close();
}

?>