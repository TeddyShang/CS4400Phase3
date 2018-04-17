<?php
session_start();
// Include config file
require_once 'config.php';
if ( isset( $_POST['submit'] ) ) {
    $email = $_POST["email"];
    $username = $_POST['username'];
    $password = $_POST["password"];
    $password = md5($password);
    $success = "Visitor succesfully created. Login from the next screen";
    $failure = "The following went wrong:";
    $f1 = "   Username was not unique.   ";
    $f2 = "   Email was not unique.   ";
    //first we check if email is unique
    //we also check if username is unique
    $checkUsername = "SELECT Username, Email, Password, UserType From User Where Username = '$username'";
    $checkEmail = "SELECT Username, Email, Password, UserType From User Where Email='$email'";
    $r1 = $conn->query($checkUsername);
    $r2 = $conn->query($checkEmail);
    if ($r1->num_rows > 0) {
        $failure .= $f1;
    }
    if ($r2->num_rows > 0) {
        $failure .= $f2;
    }

    if ($r2->num_rows > 0 || $r1->num_rows > 0 ) {
        echo $failure;
        echo "<script type='text/javascript'>alert('$failure');</script>";
        echo "<script>window.location = 'newVisitor.html'</script>";

    } else {
        $createVisitor = "INSERT INTO  `cs4400_team_1`.`User` (`Username` ,`Email` ,`Password` ,`UserType`)
        VALUES ('$username',  '$email',  '$password',  'VISITOR');";
        $conn->query($createVisitor);
        echo "<script type='text/javascript'>alert('$success');</script>";
        echo "<script>window.location = 'Login.html'</script>";
    }
    $conn ->close();
}

?>