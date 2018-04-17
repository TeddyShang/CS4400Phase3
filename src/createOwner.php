<?php
session_start();
// Include config file
require_once 'config.php';
if ( isset( $_POST['submit'] ) ) {
    $email = $_POST["email"];
    $username = $_POST['username'];
    $password = $_POST["password"];
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
    $password = md5($password);
    $success = "Owner and property successfully created. Login from the next screen";
    $failure = "The following went wrong:";
    $f1 = "   Username was not unique.   ";
    $f2 = "   Email was not unique.   ";
    $f3 = "   Property name was not unique";
    //first we check if email is unique
    //we also check if username is unique
    $checkUsername = "SELECT Username, Email, Password, UserType From User Where Username = '$username'";
    $checkEmail = "SELECT Username, Email, Password, UserType From User Where Email='$email'";
    $checkProperty = "SELECT * FROM Property Where Name = '$propname'";
    $r1 = $conn->query($checkUsername);
    $r2 = $conn->query($checkEmail);
    $r3 = $conn->query($checkProperty);
    if ($r1->num_rows > 0) {
        $failure .= $f1;
    }
    if ($r2->num_rows > 0) {
        $failure .= $f2;
    }
    if ($r3->num_rows > 0) {
        $failure .= $f3;
    }

    if ($r2->num_rows > 0 || $r1->num_rows > 0 || $r3->num_rows >0 ) {
        echo $failure;
        echo "<script type='text/javascript'>alert('$failure');</script>";
        echo "<script>window.location = 'newOwner.php'</script>";

    } else {
        if ($propType == "1") {
            $propType = "ORCHARD";
        } elseif($propType == "2") {
            $propType = "FARM";
        } else {
            $propType = "GARDEN";
        }
        $createOWNER = "INSERT INTO  `cs4400_team_1`.`User` (`Username` ,`Email` ,`Password` ,`UserType`)
        VALUES ('$username',  '$email',  '$password',  'OWNER');";
        $conn->query($createOWNER);
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
        echo $propType;
        echo $public;
        echo $commercial;
        $createProperty = "INSERT INTO  `cs4400_team_1`.`Property` (`ID` ,`Name` ,`Size` ,`IsCommercial` ,`IsPublic` ,`Street` ,`City` ,`Zip` ,`PropertyType` ,`Owner` ,`ApprovedBy`)
        VALUES ('$idValue',  '$propname',  '$acres',  '$commercial',  '$public',  '$street',  '$city',  '$zip',  '$propType',  '$username',  'NULL')";
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
        echo "<script>window.location = 'Login.html'</script>";
    }
    $conn ->close();
}

?>