<?php
// Include config file
require_once 'config.php';
if ( isset( $_POST['submit'] ) ) {
    $username = $_POST["email"];
    $password = $_POST["password"];
    $password = md5($password);
    $success = "Matching in DB";
    $failure = "The username/password combination was incorrect";
    $sql = "SELECT Email, Password, UserType From User Where (Email='$username' AND Password='$password')";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_row($result);
        if ($row[2] == "ADMIN") {
            echo "<script>window.location = 'adminHome.php'</script>";
        } elseif($row[2] == "VISITOR") {
            echo "<script>window.location = 'visitorHome.php'</script>";
        } else {
            echo "<script>window.location = 'ownerHome.php'</script>";
        }

    } else {
        echo "<script type='text/javascript'>alert('$failure');</script>";
        echo "<script>window.location = 'Login.html'</script>";
    }
    $conn ->close();
}

?>