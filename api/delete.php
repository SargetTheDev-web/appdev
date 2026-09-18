<?php

include __DIR__ . '/../initialize.php';

if (!isset($_GET['id'])) {
    header('Location: api/users.php');
    exit();
}

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id = '$id'";

if ($connection->query($sql) === TRUE) {

    echo "<script>
            alert('User has been deleted successfully!');
            window.location.href = 'users.php';
          </script>";

} else {

    echo "<script>
            alert('Error deleting user!');
            window.location.href = 'users.php';
          </script>";
}

?>