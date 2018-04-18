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
$name = $_POST["others1"];
$message = "Crop Deleted";
$sql = "DELETE FROM FarmItem Where Name = '$name'";
$conn ->query($sql);
echo "<script type='text/javascript'>alert('$message');</script>";
echo "<script>window.history.back()</script>";
?>
