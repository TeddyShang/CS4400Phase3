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
<table id="ownerProperties" class="display">
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
        <th>isValid</th>
        <th>Visits</th>
        <th>Average Rating</th>
    </tr>
    </thead>
    <tbody>
<?php
$ownerName= $_SESSION['userID'];
$sql = "SELECT Name, Street, City, Zip, Size, PropertyType, isPublic, isCommercial, ID, ApprovedBy FROM Property WHERE Owner = '$ownerName'";
$result = $conn->query($sql);

while($row = mysqli_fetch_array($result)) {
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
    if ($row['ApprovedBy'] == "NULL") {
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

    echo "<tr>";
    echo "<td>" .$row['Name'] . "</td>";
    echo "<td>" .$row['Street'] . "</td>";
    echo "<td>" .$row['City'] . "</td>";
    echo "<td>" .$row['Zip'] . "</td>";
    echo "<td>" .$row['Size'] . "</td>";
    echo "<td>" .$row['PropertyType'] . "</td>";
    echo "<td> $publicBool </td>";
    echo "<td> $commercialBool</td>";
    echo "<td>$idDigits</td>";
    echo "<td>$isValid</td>";
    echo "<td>$visits</td>";
    echo "<td>$rating</td>";
    echo "</tr>";
}


$conn ->close();
?>
    </tbody>
    <tfoot>
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
        <th>isValid</th>
        <th>Visits</th>
        <th>Average Rating</th>
    </tr>

    </tfoot>
</table>;

<script type="text/javascript" charset="utf8" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#ownerProperties tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );

        // DataTable
        var table = $('#ownerProperties').DataTable();

        // Apply the search
        table.columns().every( function () {
            var that = this;

            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    } );
</script>
</body>
</html>