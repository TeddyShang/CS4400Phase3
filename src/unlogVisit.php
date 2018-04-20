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
$username = $_SESSION['userID'];
$propID = $_POST["id2"];
$message = "Visit has been un-logged!";
$deleteVisit = "DELETE FROM Visit Where Username = '$username' AND PropertyID ='$propID'";
$conn ->query($deleteVisit);
echo "<script type='text/javascript'>alert('$message');</script>";
echo "<script>window.location = 'visitorHome.php'</script>";
?>
