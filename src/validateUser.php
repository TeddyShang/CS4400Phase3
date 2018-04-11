<?php
// Include config file
require_once 'config.php';
if ( isset( $_POST['submit'] ) ) {
    $username = $_POST["email"];
    $password = $_POST["password"];
    $password = md5($password);
    $success = "Matching in DB";
    $failure = "The username/password combination was incorrect";
    echo "$username";
    echo "$password";
    $sql = "SELECT Email, Password From User Where (Email='$username' AND Password='$password')";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<script type='text/javascript'>alert('$success');</script>";
    } else {
        echo "<script type='text/javascript'>alert('$failure');</script>";
        echo "<script>window.location = 'Login.html'</script>";
    }
    $conn ->close();
}

?>