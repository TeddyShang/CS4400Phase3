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
<h1>Approved Animals/Crops</h1>
<table id="approved" class="table table-striped table-bordered" style="width:100%">
    <thead>
    <tr>
        <th>Name</th>
        <th>Type</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sql = "SELECT Name, Type FROM FarmItem WHERE IsApproved = '1'";
    $result = $conn->query($sql);

    while($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" .$row['Name'] . "</td>";
        echo "<td>" .$row['Type'] . "</td>";
        echo "</tr>";
    }


    $conn ->close();
    ?>
    </tbody>
    <tfoot>
    <tr>
        <th>Name</th>
        <th>Type</th>
    </tr>

    </tfoot>
</table>
<div class ="text-center">
<form class = "needs-validation" novalidate action="addCrop.php" method="post">
    <div class ="form-group row">
        <label class="col-sm-2 col-form-label">Add Animal/Crop*:</label>
        <div class="col-md-4 mb-3">
            <select class="custom-select custom-select mb-3"  name = "cropType" required id = "cropType">
                <option value="">Open this select menu</option>
                <option value="ANIMAL">Animal</option>
                <option value="FRUIT">Fruit</option>
                <option value="VEGETABLE">Vegetable</option>
                <option value="FLOWER">Flower</option>
                <option value="NUT">Nut</option>
            </select>
        </div>
        <div class="form-group row">
            <label for="cropName"class="col-sm-2 col-form-label">Animal/Crop Name*:</label>
            <div class="col-md-4 mb-3">
                <input type="text" required class="form-control" name = "cropName" id="cropName" placeholder="Enter Name"">
            </div>
        </div>
        <button class="btn btn-primary btn-lg" name ="submit" type="submit">Add to Approved List</button>
</form>
</div>
<div class = "mt-2 text-center">
    <form action = "deleteFarmItem.php" method ="post">
        <button name="others1"class="btn btn-primary btn-lg" id="others1" value="">Delete Selection</button>
    </form>
    <br>
    <a href="adminHome.php" class="btn btn-primary btn-lg" role="button">Back</a>
</div>

<script type="text/javascript" charset="utf8" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#approved tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );

        // DataTable
        var table = $('#approved').DataTable();

        //What is clicked
        $('#approved tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );
        //Get info from selected row
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
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
// Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
// Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
</body>
</html>