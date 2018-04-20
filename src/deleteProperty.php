<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['userID'])){
    echo "<script type='text/javascript'>alert('You are not logged in!');</script>";
    echo "<script>window.location = 'Login.html'</script>";
}
?>
<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<?php
$propName = $_POST["delete"];
$message = "Property removed from database";
$sql = "DELETE FROM Property Where Name = '$propName'";
$conn ->query($sql);
echo "<script type='text/javascript'>alert('$message');</script>";
echo "<script>window.location = 'adminHome.php'</script>";
?>
