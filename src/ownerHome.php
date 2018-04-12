<?php
session_start();
require_once 'config.php';
?>

<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
</head>
<body>
<h1>Welcome <?php echo $_SESSION['userID']?></h1>
<h1>Your Properties:</h1>
<table id="example" class="display">
    <thead>
    <tr>
        <th>Name</th>
        <th>Street</th>
        <th>City</th>
        <th>Zip</th>
        <th>Size</th>
        <th>PropertyType</th>
        <th>isPublic</th>
        <th>isCommerical</th>
        <th>ID</th>
    </tr>
    </thead>
    <tbody>
<?php
$ownerName= $_SESSION['userID'];
$sql = "SELECT Name, Street, City, Zip, Size, PropertyType, isPublic, isCommercial, ID FROM Property WHERE Owner = '$ownerName'";
$result = $conn->query($sql);

while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" .$row['Name'] . "</td>";
    echo "<td>" .$row['Street'] . "</td>";
    echo "<td>" .$row['City'] . "</td>";
    echo "<td>" .$row['Zip'] . "</td>";
    echo "<td>" .$row['Size'] . "</td>";
    echo "<td>" .$row['PropertyType'] . "</td>";
    echo "<td>" .$row['isPublic'] . "</td>";
    echo "<td>" .$row['isCommercial'] . "</td>";
    echo "<td>" .$row['ID'] . "</td>";
    echo "</tr>";
}


$conn ->close();
?>
    </tbody>
</table>;

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script>
    $(function(){
        $("#example").dataTable();
    })
</script>
</body>
</html>