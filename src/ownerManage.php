<?php
session_start();
require_once 'config.php';
$propertyName = $_POST['others'];
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title><?php echo "Manage " . $propertyName?></title>
</head>
<body>
<?php
$sql = "SELECT Name, Street, City, Zip, Size, PropertyType, isPublic, isCommercial, ID, Owner, ApprovedBy FROM Property WHERE Name = '$propertyName'";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result);
$street= $row['Street'];
$city= $row['City'];
$zip= $row['Zip'];
$size = $row['Size'];
$propType = $row['PropertyType'];
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
?>
<div class ="text-center">
    <h1><?php echo "Manage " . $propertyName?></h1>
    <form class = "needs-validation" novalidate action="ownerUpdateProperty.php" method="post">
        <div class="form-group row">
            <label for="propertyName"class="col-sm-2 col-form-label">Property Name*:</label>
            <div class="col-md-4 mb-3">
                <input type="text" required class="form-control" name = "propname" value="<?php echo $propertyName?>"id="propertyName" placeholder="Property Name">
            </div>
        </div>
        <div class="form-group row">
            <label for="streetAddress"class="col-sm-2 col-form-label">Street Address*:</label>
            <div class="col-md-4 mb-3">
                <input type="text" required class="form-control" name ="street" value="<?php echo $street?>"id="streetAddress" placeholder="Street Address">
            </div>
        </div>
        <div class="form-group row">
            <label for="city"class="col-sm-2 col-form-label">City*:</label>
            <div class="col-md-4 mb-3">
                <input type="text" required class="form-control" name ="city" value="<?php echo $city?>" id="city" placeholder="City Name">
            </div>
        </div>
        <div class="form-group row">
            <label for="zip"class="col-sm-2 col-form-label">Zip*:</label>
            <div class="col-md-4 mb-3">
                <input type="number" required class="form-control" name = "zip" id="zip" value="<?php echo $zip?>"placeholder="Zip Code" min="10000" max="99999">
            </div>
        </div>
        <div class="form-group row">
            <label for="acres" class="col-sm-2 col-form-label">Acres*:</label>
            <div class="col-md-4 mb-3">
                <input type="number" required class="form-control" step="any" name ="acres" id="acres" value="<?php echo $size?>" placeholder="Number of Acres" min="0">
            </div>
        </div>
        <div class ="form-group row">
            <label class="col-sm-2 col-form-label">Property Type*:</label>
            <div class="col-md-4 mb-3">
                <?php
                echo $propType;
                ?>
            </div>
        </div>
        <div class ="form-group row">
            <label class="col-sm-2 col-form-label">ID:</label>
            <div class="col-md-4 mb-3">
                <?php
                echo $idDigits;
                ?>
            </div>
        </div>
        <div class ="form-group row">
            <label class="col-sm-2 col-form-label">Public?*:</label>
            <div class="col-md-4 mb-3">
                <select class="custom-select custom-select mb-3" name="public" required>
                    <?php
                    if ($publicBool == "True") {
                        echo "<option value=\"1\" selected>True</option>
                    <option value=\"0\">False</option>";
                    } else {
                        echo "<option value=\"1\">True</option>
                    <option value=\"0\" selected>False</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class ="form-group row">
            <label class="col-sm-2 col-form-label">Commercial?*:</label>
            <div class="col-md-4 mb-3">
                <select class="custom-select custom-select- mb-3" name = "commercial" required>
                    <?php
                    if ($commercialBool == "True") {
                        echo "<option value=\"1\" selected>True</option>
                    <option value=\"0\">False</option>";
                    } else {
                        echo "<option value=\"1\">True</option>
                    <option value=\"0\" selected>False</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class ="form-group row">
            <label class="col-sm-2 col-form-label">Choose Animal to Remove?:</label>
            <div class="col-md-4 mb-3">
                <select class="custom-select custom-select- mb-3" name = "deleteAnimal">
                    <?php
                    $cropSQL = "SELECT Name, Type, IsApproved FROM (Has NATURAL JOIN FarmItem) WHERE (PropertyID = '$id' AND Has.ItemName = FarmItem.Name AND Type = 'ANIMAL')";
                    $cropResult = $conn->query($cropSQL);
                    if($cropResult->num_rows == 1) {
                        echo "<option value=\"\">You cannot remove the last animal</option>";
                    } else {
                        echo"<option value =\"\">Open this Menu</option>";
                        while ($crow = mysqli_fetch_array($cropResult)) {
                            if ($crow['Type'] == "ANIMAL") {
                                $cropName = $crow['Name'];
                                echo "<option value=\"$cropName\">$cropName</option>";
                            }
                        }
                    }

                    ?>
                </select>
            </div>
        </div>
        <div class ="form-group row">
            <label class="col-sm-2 col-form-label">Choose Crop to Remove?:</label>
            <div class="col-md-4 mb-3">
                <select class="custom-select custom-select- mb-3" name = "deleteCrop">
                    <?php
                    $cropSQL = "SELECT Name, Type, IsApproved FROM (Has NATURAL JOIN FarmItem) WHERE (PropertyID = '$id' AND Has.ItemName = FarmItem.Name AND Type != 'ANIMAL')";
                    $cropResult = $conn->query($cropSQL);
                    if($cropResult->num_rows == 1) {
                        echo "<option value=\"\">You cannot remove the last crop</option>";
                    } else {
                        echo "<option value =\"\">Open this menu</option>";
                        while ($crow = mysqli_fetch_array($cropResult)) {
                            if ($crow['Type'] != "ANIMAL"){
                                $cropName = $crow['Name'];
                                echo "<option value=\"$cropName\">$cropName</option>";
                            }
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class ="form-group row">
            <label class="col-sm-2 col-form-label">Choose Animal to Add?:</label>
            <div class="col-md-4 mb-3">
                <select class="custom-select custom-select- mb-3" name = "addAnimal">
                    <?php
                    if ($propType == "FARM") {
                        echo "<option value =\"\">Open this menu</option>";
                        $cropSQL = "SELECT Name, Type, IsApproved FROM FarmItem WHERE  IsApproved = 1 ";
                        $cropResult = $conn->query($cropSQL);
                        while ($crow = mysqli_fetch_array($cropResult)) {
                            if ($crow['Type'] == "ANIMAL") {
                                $cropName = $crow['Name'];
                                echo "<option value=\"$cropName\">$cropName</option>";
                            }
                        }
                    } else {
                        echo " <option value =\"\">Can only add animals to farms</option>";
                    }

                    ?>
                </select>
            </div>
        </div>
        <div class ="form-group row">
            <label class="col-sm-2 col-form-label">Choose Crop to Add?:</label>
            <div class="col-md-4 mb-3">
                <select class="custom-select custom-select- mb-3" name = "addCrop">
                    <option value ="">Open this menu</option>
                    <?php
                    $cropSQL = "SELECT Name, Type, IsApproved FROM FarmItem WHERE  IsApproved = 1";
                    $cropResult = $conn->query($cropSQL);
                    while ($crow = mysqli_fetch_array($cropResult)) {
                        if($propType = "GARDEN") {
                            if ($crow['Type'] == "VEGETABLE" || $crow['Type'] == "FLOWER") {
                                $cropName = $crow['Name'];
                                echo "<option value=\"$cropName\">$cropName</option>";
                            }
                        } else {
                            if ($crow['Type'] == "FRUIT" || $crow['Type'] == "NUT") {
                                $cropName = $crow['Name'];
                                echo "<option value=\"$cropName\">$cropName</option>";
                            }
                        }

                    }
                    ?>
                </select>
            </div>
        </div>
        <button class="btn btn-primary btn-lg"  value='<?php echo$id;?>'name ="submit" type="submit">Save Changes</button>
        <small id="note" class="form-text text-muted">Save any changes before trying to request any new crops</small>
    </form>
    <br>
    <div class ="text-center">
        <form class = "needs-validation" novalidate action="addCropO.php" method="post">
            <div class ="form-group row">
                <label class="col-sm-2 col-form-label">Request Crop Approval:</label>
                <div class="col-md-4 mb-3">
                    <select class="custom-select custom-select mb-3"  name = "cropType" required id = "cropType">
                        <option value="">Open this select menu</option>
                        <option value="ANIMAL">Animal</option>
                        <option value="FRUIT">Fruit</option>
                        <option value="VEGETABLE">Vegetable</option>
                        <option value="FLOWER">Flower</option>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="cropName"class="col-sm-2 col-form-label">Crop Name*:</label>
                    <div class="col-md-4 mb-3">
                        <input type="text" required class="form-control" name = "cropName" id="cropName" placeholder="Enter Name"">
                    </div>
                </div>
                <button class="btn btn-primary btn-lg" type="submit">Submit Request</button>
        </form>
    </div>
    <br>
    <br>
    <button onclick= "goBack()" class="btn btn-primary btn-lg" role="button">Back (Don't Save)</button>
    <form action="deletePropertyO.php" method="post">
        <br>
        <button class="btn btn-primary btn-lg" name ="delete"  value="<?php echo$propertyName;?>" type="submit">Delete Property</button>
    </form>
</div>
</body>
<!-- Optional JavaScript -->
<script>
    function goBack() {
        window.history.back();
    }
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

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
