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
$cropType = $_POST["cropType"];
$cropName = $_POST["cropName"];

$message = "Crop Request for " . $cropName . " has been submitted!";
$sql = "INSERT INTO  `cs4400_team_1`.`FarmItem` (`Name` ,`IsApproved` ,`Type`)
    VALUES ('$cropName', '0', '$cropType')";

$conn ->query($sql);
echo "<script type='text/javascript'>alert('$message');</script>";
echo "<script>window.location = 'ownerHome.php'</script>"
?>
