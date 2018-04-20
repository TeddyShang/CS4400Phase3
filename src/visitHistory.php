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
<h1>Your Visit History</h1>
<table id="history" class="table table-striped table-bordered" style="width:100%">
    <thead>
    <tr>
        <th>Name</th>
        <th>Date Logged</th>
        <th>Rating</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $username = $_SESSION['userID'];
    $sql = "SELECT Name, VisitDate, Rating FROM (Visit JOIN Property ON PropertyID = ID) WHERE (Username = '$username')";
    $result = $conn->query($sql);

    while($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" .$row['Name'] . "</td>";
        echo "<td>" .$row['VisitDate'] . "</td>";
        echo "<td>" .$row['Rating'] . "</td>";
        echo "</tr>";
    }

    $conn ->close();
    ?>
    </tbody>
    <tfoot>
    <tr>
        <th>Name</th>
        <th>Date Logged</th>
        <th>Rating</th>

    </tr>

    </tfoot>
</table>
<div class = "mt-2 text-center">
    <form action = "visitorViewDetails.php" method ="post">
        <button name="others"class="btn btn-primary btn-lg" id="others" value="">View Property Details</button>
    </form>
    <br>
    <a href="visitorHome.php" class="btn btn-primary btn-lg" role="button">Back</a>
</div>

<script type="text/javascript" charset="utf8" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#history tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );

        // DataTable
        var table = $('#history').DataTable();

        //What is clicked
        $('#history tbody').on( 'click', 'tr', function () {
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