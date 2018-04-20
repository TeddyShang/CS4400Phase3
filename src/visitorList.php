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
<h1>All Visitors in System</h1>
<table id="allVisitors" class="table table-striped table-bordered" style="width:100%">
    <thead>
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Logged Visits</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sql = "SELECT Username, Email FROM User WHERE UserType = 'VISITOR'";
    $result = $conn->query($sql);

    while($row = mysqli_fetch_array($result)) {
        $username = $row['Username'];
        $visitorStatsSQL = "SELECT COUNT(PropertyID) FROM (User Natural JOIN Visit) WHERE Username = '$username'";
        $statsResult = $conn->query($visitorStatsSQL);
        $stats = mysqli_fetch_array($statsResult);
        $visits = $stats[0];
        echo "<tr>";
        echo "<td>" .$row['Username'] . "</td>";
        echo "<td>" .$row['Email'] . "</td>";
        echo "<td>$visits</td>";
        echo "</tr>";
    }


    $conn ->close();
    ?>
    </tbody>
    <tfoot>
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Logged Visits</th>
    </tr>

    </tfoot>
</table>
<div class = "mt-2 text-center">
    <form action = "deleteUser.php" method ="post">
        <button name="others"class="btn btn-primary btn-lg" id="others" value="">Delete Visitor Account</button>
    </form>
    <br>
    <form action = "deleteLogHistory.php" method ="post">
        <button name="others1"class="btn btn-primary btn-lg" id="others1" value="">Delete Log History</button>
    </form>
    <br>
    <a href="adminHome.php" class="btn btn-primary btn-lg" role="button">Back</a>
</div>

<script type="text/javascript" charset="utf8" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#allVisitors tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );

        // DataTable
        var table = $('#allVisitors').DataTable();

        //What is clicked
        $('#allVisitors tbody').on( 'click', 'tr', function () {
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
        $('#others1').click( function () {
            //table.row('.selected').remove().draw( false );
            var data = table.row('.selected').data();
            var id = data[0];
            var button = document.getElementById("others1");
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