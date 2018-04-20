<?php
session_start();
if (!isset($_SESSION['userID'])){
    echo "<script type='text/javascript'>alert('You are not logged in!');</script>";
    echo "<script>window.location = 'Login.html'</script>";
}
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
$cropType = $_POST["cropType"];
$cropName = $_POST["cropName"];

$message = "Crop " .$cropName . " of type " . $cropType . " added!";
$sql = "INSERT INTO  `cs4400_team_1`.`FarmItem` (`Name` ,`IsApproved` ,`Type`)
    VALUES ('$cropName', '1', '$cropType')";

$conn ->query($sql);
echo "<script type='text/javascript'>alert('$message');</script>";
echo "<script>window.history.back()</script>";
?>
