<?php include'initialize.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Record List</title>
</head>
<body>
<div align="center">
    <h3>User's Record List</h3>
    <?php
        if(isset($_SESSION['alert_message'])) {
            echo'<div align="center">'. $_SESSION['alert_message'] .'</div>';
            unset($_SESSION['alert_message']);
        }
    ?>
    <br />
    <a href="user_add.php">Add User</a>
</div>
</body>
</html>
