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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>AdminHome</title>
</head>
<body>
<h1>Welcome <?php echo $_SESSION['userID']?></h1>
<div class = "mt-2 text-center">
    <a href="visitorList.php" class="btn btn-primary btn-lg" role="button">View Visitor List</a>
    <a href="ownerList.php" class="btn btn-primary btn-lg" role="button">View Owners List</a>
    <a href="confirmedPropertyList.php" class="btn btn-primary btn-lg" role="button">View Confirmed Properties</a>
    <a href="unconfirmedPropertyList.php" class="btn btn-primary btn-lg" role="button">View Unconfirmed Properties</a>
    <a href="approvedAnimalsCrops.php" class="btn btn-primary btn-lg" role="button">View Approved Animals and crops</a>
    <a href="pendingAnimalsCrops.php" class="btn btn-primary btn-lg" role="button">View Pending Animals and Crops</a>
    <a href="logOut.php" class="btn btn-primary btn-lg" role="button">Log Out</a>
</div>
</body>