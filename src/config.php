<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

$servername = "academic-mysql.cc.gatech.edu";
$username = "cs4400_team_1";
$password = "kJXYz5he";
$dbname = "cs4400_team_1";

/* Attempt to connect to MySQL database */
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>


