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
$rating = $_POST["rating"];
$propID = $_POST["id"];
$message = "Visit has been logged!";
$createVisit = "INSERT INTO  `cs4400_team_1`.`Visit` (`Username` ,`PropertyID` ,`VisitDate` ,`Rating`)
        VALUES ('$username',  '$propID',  now(),  '$rating');";
$conn ->query($createVisit);
echo "<script type='text/javascript'>alert('$message');</script>";
echo "<script>window.location = 'visitorHome.php'</script>";
?>
