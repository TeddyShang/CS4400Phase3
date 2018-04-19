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
<h1>Welcome <?php echo $_SESSION['userID']?></h1>
<h1>All public, validated properties:</h1>
<table border="0" cellspacing="5" cellpadding="5">
    <tbody><tr>
        <td>Minimum Visits</td>
        <td><input type="text" id="min" name="min"></td>
    </tr>
    <tr>
        <td>Maximum Visits</td>
        <td><input type="text" id="max" name="max"></td>
    </tr>
    </tbody></table>
<table border="0" cellspacing="5" cellpadding="5">
    <tbody><tr>
        <td>Minimum Rating</td>
        <td><input type="text" id="min1" name="min1"></td>
    </tr>
    <tr>
        <td>Maximum Rating</td>
        <td><input type="text" id="max1" name="max1"></td>
    </tr>
    </tbody></table>
<table id="validProperties" class="table table-striped table-bordered" style="width:100%">
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
    $sql = "SELECT Name, Street, City, Zip, Size, PropertyType, isPublic, isCommercial, ID, ApprovedBy FROM Property WHERE (isPublic = '1' AND ApprovedBy IS NOT NULL)";
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
</table>
<div class = "mt-2 text-center">
    <form action = "visitorViewDetails.php" method ="post">
        <button name="others"class="btn btn-primary btn-lg" id="others" value="">View Property</button>
    </form>
    <br>
    <a href="visitHistory.php" class="btn btn-primary btn-lg" role="button">View Visit History</a>
    <br>
    <br>
    <a href="logOut.php" class="btn btn-primary btn-lg" role="button">Log Out</a>
</div>

<script type="text/javascript" charset="utf8" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
<script>
    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseInt( $('#min').val(), 10 );
            var max = parseInt( $('#max').val(), 10 );
            var age = parseFloat( data[10] ) || 0; // use data for the visit column

            if ( ( isNaN( min ) && isNaN( max ) ) ||
                ( isNaN( min ) && age <= max ) ||
                ( min <= age   && isNaN( max ) ) ||
                ( min <= age   && age <= max ) )
            {
                return true;
            }
            return false;
        }
    );
    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseFloat( $('#min1').val(), 10 );
            var max = parseFloat( $('#max1').val(), 10 );
            var age = parseFloat( data[11] ) || 0; // use data for the ratings column

            if ( ( isNaN( min ) && isNaN( max ) ) ||
                ( isNaN( min ) && age <= max ) ||
                ( min <= age   && isNaN( max ) ) ||
                ( min <= age   && age <= max ) )
            {
                return true;
            }
            return false;
        }
    );

    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#validProperties tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );

        // DataTable
        var table = $('#validProperties').DataTable();
        $('#min, #max').keyup( function() {
            table.draw();
        } );
        var table = $('#validProperties').DataTable();
        $('#min1, #max1').keyup( function() {
            table.draw();
        } );


        //What is clicked
        $('#validProperties tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );
        //Get info from selected row
        $('#others').click( function () {
            //table.row('.selected').remove().draw( false );
            var data = table.row('.selected').data();
            var id = data[0];
            var button = document.getElementById("others");
            button.value = id;
            //alert(id);
        } );

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