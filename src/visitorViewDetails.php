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
$propName = $_POST["others"];
echo "<h1>" . $propName . " Details </h1>";
$sql = "SELECT Name, Street, City, Zip, Size, PropertyType, isPublic, isCommercial, ID, Owner, ApprovedBy FROM Property WHERE Name = '$propName'";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result);
$publicBool;
$commercialBool;
$id = $row['ID'];
$idDigits = sprintf('%05d', $row['ID']);
if ($row['isPublic'] == 1) {
    $publicBool = "True";
} else {
    $publicBool = "False";
}
if ($row['isCommercial'] == 1) {
    $commercialBool = "True";
} else {
    $commercialBool = "False";
}
$isValid;
if ($row['ApprovedBy'] == NULL) {
    $isValid = "False";
} else {
    $isValid = "True";
}
$visitorStatsSQL = "SELECT COUNT(PropertyID), AVG(Rating) FROM Visit WHERE PropertyID = '$id'";
$statsResult = $conn->query($visitorStatsSQL);
$stats = mysqli_fetch_array($statsResult);
$visits = $stats[0];
$rating = $stats[1];
if (!($rating>0)) {
    $rating = "N/A";
}
$userE = $row['Owner'];
$ownerEmailSQL ="SELECT Email FROM User WHERE Username ='$userE'";
$emailResult = $conn->query($ownerEmailSQL);
$email = mysqli_fetch_array($emailResult);
$cropSQL = "SELECT Name, Type, IsApproved FROM (Has NATURAL JOIN FarmItem) WHERE (PropertyID = '$id' AND Has.ItemName = FarmItem.Name)";
$cropResult = $conn->query($cropSQL);
$crops = "";
$animals = "";
while ($crow = mysqli_fetch_array($cropResult)) {
    if ($crow['Type'] != "ANIMAL") {
        $crops = $crops . " ". $crow['Name'] . ",";
    } else {
        $animals = $animals ." ". $crow['Name'] . ",";
    }
}
$crops =rtrim($crops,',');
$animals =rtrim($animals,',');
echo "<div class=\"col-md-4 mb-3\">";
echo "Name:   " . $row['Name'];
echo "<br>";
echo "Owner:   " . $row['Owner'];
echo "<br>";
echo "Owner Email:   " . $email['Email'];
echo "<br>";
echo "Visits:   " . $visits;
echo "<br>";
echo "Address:   " . $row['Street'];
echo "<br>";
echo "City:   " . $row['City'];
echo "<br>";
echo "Zip:   " . $row['Zip'];
echo "<br>";
echo "Size(acres):   " . $row['Size'];
echo "<br>";
echo "Avg. Rating:   " . $rating;
echo "<br>";
echo "Type:   " . $row['PropertyType'];
echo "<br>";
echo "Public:   " . $publicBool;
echo "<br>";
echo "Commercial:   " . $commercialBool;
echo "<br>";
echo "ID:   " . $idDigits;
echo "<br>";
echo "Crops:   " . $crops;
echo "<br>";
if ($row['PropertyType'] == "FARM") {
    echo "Animals:   " . $animals;
}
echo "</div>";

?>
<br>
<br>
<?php
$username = $_SESSION['userID'];
$visitedSQL = "SELECT * FROM Visit WHERE  Username = '$username' AND PropertyID = '$id'";
$result = $conn->query($visitedSQL);
if ($result->num_rows == 0) {
    echo "<div class=\"col-md-4 mb-3\"><form action = \"logVisit.php\" method =\"post\">
            <select class=\"custom-select custom-select mb-3\"  name = \"rating\" required id = \"rating\">
                <option value=\"\">Rate your Visit</option>
                <option value=\"1\">1</option>
                <option value=\"2\">2</option>
                <option value=\"3\">3</option>
                <option value=\"4\">4</option>
                <option value=\"5\">5</option>
            </select>

        <button class=\"btn btn-primary btn-lg\" name='id' id='id' value=\"$id\">Log Visit</button>
    </form></div>";
} else{
    echo "<form action = \"unlogVisit.php\" method =\"post\">
        <button class=\"btn btn-primary btn-lg\" name = 'id2' value=\"$id\">Un-Log Visit</button>
    </form>";
}

?>
<br>
<div class="col-md-4 mb-3">
<a href= "visitorHome.php"class="btn btn-primary btn-lg" role="button">Back</a>
</div>
</body>

