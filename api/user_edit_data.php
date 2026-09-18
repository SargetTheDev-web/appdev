<?php

include 'initialize.php';

$id = $_POST['id'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$password = $_POST['password'];

if (empty($firstname)) {

    echo "<script>
            alert('Firstname is required!');
            window.history.back();
          </script>";
    exit();

} elseif (empty($lastname)) {

    echo "<script>
            alert('Lastname is required!');
            window.history.back();
          </script>";
    exit();

} elseif (empty($username)) {

    echo "<script>
            alert('Username is required!');
            window.history.back();
          </script>";
    exit();

} elseif (empty($password)) {

    echo "<script>
            alert('Password is required!');
            window.history.back();
          </script>";
    exit();

}

$sql = "UPDATE users SET
            firstname = '$firstname',
            lastname = '$lastname',
            username = '$username',
            password = '$password'
        WHERE id = '$id'";

if ($connection->query($sql) === TRUE) {

    echo "<script>
            alert('User has been updated successfully!');
            window.location.href = 'users.php';
          </script>";

} else {

    echo "<script>
            alert('Error updating user!');
            window.history.back();
          </script>";
}

?>