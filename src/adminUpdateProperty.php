<?php
session_start();
require_once 'config.php';
?>
    <!doctype html>
    <html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    </head>
    <body>
<?php
$username = $_SESSION['userID'];
$propName = $_POST["propname"];
$id = $_POST["submit"];
$address = $_POST["street"];
$city = $_POST["city"];
$zip = $_POST["zip"];
$acres = $_POST["acres"];
$public = $_POST["public"];
$commercial = $_POST["commercial"];
$deleteAnimal = $_POST["deleteAnimal"];
$deleteCrop = $_POST["deleteCrop"];
$addAnimal = $_POST["addAnimal"];
$addCrop = $_POST["addCrop"];
$message = "Property has been confirmed and updated!";
$checkPropName = "SELECT * FROM Property WHERE (ID != '$id' AND Name = '$propName')";
$checkName = $conn ->query($checkPropName);
$failure = "Cannot change your property name to one that already exists!";
if($checkName->num_rows > 0) {
    echo "<script type='text/javascript'>alert('$failure');</script>";
    echo "<script>window.location.back()</script>";
} else {
    $updateProperty = "UPDATE Property SET Name = '$propName', Street = '$address', City ='$city', Zip ='$zip', Size='$acres', IsPublic = '$public', IsCommercial= '$commercial', ApprovedBy ='$username' WHERE ID = '$id'";
    $conn->query($updateProperty);
    if ($deleteAnimal != "") {
        $deleteAnimalQ = "DELETE FROM Has WHERE (PropertyID = '$id' AND ItemName = '$deleteAnimal')";
        $conn->query($deleteAnimalQ);
    }
    if ($deleteCrop != "") {
        $deleteCropQ = "DELETE FROM Has WHERE (PropertyID = '$id' AND ItemName = '$deleteCrop')";
        $conn->query($deleteCropQ);
    }
    if ($addAnimal != "") {
        $addAnimalQ = "INSERT INTO  `cs4400_team_1`.`Has` (`PropertyID` ,`ItemName`)
    VALUES ('$id','$addAnimal')";
        $conn->query($addAnimalQ);

    }
    if ($addCrop != "") {
        $addCropQ = "INSERT INTO  `cs4400_team_1`.`Has` (`PropertyID` ,`ItemName`)
    VALUES ('$id','$addCrop')";
        $conn->query($addCropQ);
    }
    $deleteVisits = "DELETE FROM Visit WHERE PropertyID = '$id'";
    $conn->query($deleteVisits);

    echo "<script type='text/javascript'>alert('$message');</script>";
    echo "<script>window.location = 'adminHome.php'</script>";

}

?>