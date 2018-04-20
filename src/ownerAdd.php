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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Add New Property</title>
</head>
<body>
<div class ="text-center">
    <h1>Add New Property</h1>
    <form class = "needs-validation" novalidate action="createProperty.php" method="post">
        <div class="form-group row">
            <label for="propertyName"class="col-sm-2 col-form-label">Property Name*:</label>
            <div class="col-md-4 mb-3">
                <input type="text" required class="form-control" name = "propname" id="propertyName" placeholder="Property Name">
                <small id="propertyNameHelp" class="form-text text-muted">What is the name of your property?</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="streetAddress"class="col-sm-2 col-form-label">Street Address*:</label>
            <div class="col-md-4 mb-3">
                <input type="text" required class="form-control" name ="street" id="streetAddress" placeholder="Street Address">
                <small id="addressHelp" class="form-text text-muted">Enter the property's address</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="city"class="col-sm-2 col-form-label">City*:</label>
            <div class="col-md-4 mb-3">
                <input type="text" required class="form-control" name ="city" id="city" placeholder="City Name">
                <small id="cityHelp" class="form-text text-muted">Enter the city of your property</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="zip"class="col-sm-2 col-form-label">Zip*:</label>
            <div class="col-md-4 mb-3">
                <input type="number" required class="form-control" name = "zip" id="zip" placeholder="Zip Code" min="10000" max="99999">
                <small id="zipHelp" class="form-text text-muted">Enter the 5 digit zipcode of your property</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="acres" class="col-sm-2 col-form-label">Acres*:</label>
            <div class="col-md-4 mb-3">
                <input type="number" required class="form-control" name ="acres" id="acres" placeholder="Number of Acres" min="0">
                <small id="acreHelp" class="form-text text-muted">Enter your property's acreage</small>
            </div>
        </div>
        <div class ="form-group row">
            <label class="col-sm-2 col-form-label">Property Type*:</label>
            <div class="col-md-4 mb-3">
                <select class="custom-select custom-select mb-3"  name = "propType" required onchange="dontshow(this)" id = "property">
                    <option value="">Open this select menu</option>
                    <option value="1">Orchard</option>
                    <option value="2">Farm</option>
                    <option value="3">Garden</option>
                </select>
            </div>
        </div>
        <div class ="form-group row">
            <label class="col-sm-2 col-form-label">Animal*:</label>
            <div class="col-md-4 mb-3" id = "animal">
                <select class="custom-select custom-select mb-3" name="animal" required>
                    <?php
                    // Include config file
                    require_once 'config.php';
                    $sql = "SELECT Name FROM FarmItem WHERE (Type='ANIMAL' AND IsApproved = 1)";
                    $result = $conn->query($sql);
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<option>" . $row{'Name'} . "</option>";
                    }

                    ?>
                </select>
            </div>
        </div>
        <div class ="form-group row">
            <label class="col-sm-2 col-form-label">Crop*:</label>
            <div class="col-md-4 mb-3" id="farm">
                <select class="custom-select custom-select mb-3" name="allCrops" required>
                    <?php
                    // Include config file
                    $sql = "SELECT Name FROM FarmItem WHERE ((Type='FRUIT' OR TYPE='FLOWER' OR TYPE = 'VEGETABLE' OR TYPE='NUT') AND IsAPPROVED = 1)";
                    $result = $conn->query($sql);
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<option>" . $row{'Name'} . "</option>";
                    }

                    ?>
                </select>
            </div>
            <div class="col-md-4 mb-3" id="orchard">
                <select class="custom-select custom-select mb-3" name="garden"required>
                    <?php
                    // Include config file
                    $sql = "SELECT Name FROM FarmItem WHERE ((TYPE='FLOWER' OR TYPE = 'VEGETABLE') AND IsAPPROVED = 1)";
                    $result = $conn->query($sql);
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<option>" . $row{'Name'} . "</option>";
                    }

                    ?>
                </select>
            </div>
            <div class="col-md-4 mb-3" id="garden">
                <select class="custom-select custom-select mb-3" name ="orchard" required>
                    <?php
                    // Include config file
                    $sql = "SELECT Name FROM FarmItem WHERE ((Type='FRUIT'OR TYPE='NUT') AND IsAPPROVED = 1)";
                    $result = $conn->query($sql);
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<option>" . $row{'Name'} . "</option>";
                    }
                    $conn ->close();

                    ?>
                </select>
            </div>
        </div>
        <div class ="form-group row">
            <label class="col-sm-2 col-form-label">Public?*:</label>
            <div class="col-md-4 mb-3">
                <select class="custom-select custom-select mb-3" name="public" required>
                    <option value="">Open this select menu</option>
                    <option value="1">Yes</option>
                    <option value="2">No</option>
                </select>
            </div>
        </div>
        <div class ="form-group row">
            <label class="col-sm-2 col-form-label">Commercial?*:</label>
            <div class="col-md-4 mb-3">
                <select class="custom-select custom-select- mb-3" name = "commercial" required>
                    <option value="">Open this select menu</option>>
                    <option value="1">Yes</option>
                    <option value="2">No</option>
                </select>
            </div>
        </div>
        <button class="btn btn-primary btn-lg" name ="submit" type="submit">Add Property</button>
        <a href="ownerHome.php" class="btn btn-primary btn-lg" role="button">Cancel</a>
    </form>
</div>


<!-- Optional JavaScript -->
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
<script>
    dontshow("0");
    function check(input) {
        if (input.value != document.getElementById('inputPassword').value) {
            input.setCustomValidity('Password Must be Matching.');
        } else {
            // input is valid -- reset the error message
            input.setCustomValidity('');
        }
    }
    function dontshow(sel) {
        var w = document.getElementById('farm');
        var x = document.getElementById('animal');
        var y = document.getElementById('orchard');
        var z = document.getElementById('garden');
        if (sel.value != "2") {
            x.style.display = "none";
            w.style.display = "none";
        } else {
            x.style.display = "block";
            w.style.display = "block";
        }
        if (sel.value != "1") {
            y.style.display = "none";
        } else {
            y.style.display = "block";
        }
        if (sel.value != "3") {
            z.style.display = "none";
        } else {
            z.style.display = "block";
        }

    }
</script>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>