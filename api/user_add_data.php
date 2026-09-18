
<?php include __DIR__ . '/../initialize.php'; ?>

<?php

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];


    if(empty($firstname)) {

        $error_message = "Firstname is required";

    } elseif(empty($lastname)) {

        $error_message = "Lastname is required";

    } elseif(empty($password)) {

        $error_message = "Password is required";

    } elseif(empty($username)) {

        $error_message = "Username is required";

    } elseif(empty($confirm_password)) {

        $error_message = "Confirm Password is required";

    } elseif($confirm_password !== $password) {

        $error_message = "Password and confirm password not match";

    } else {

        $error_message = null;

    }


    /* ERROR */

    if(!empty($error_message)) {

        $_SESSION['alert_message'] = $error_message;

        header('Location: user_create.php');

        exit();

    }


    /* INSERT USER */

    $sql = "INSERT INTO users (
                firstname,
                lastname,
                username,
                password
            ) VALUES (
                '".$firstname."',
                '".$lastname."',
                '".$username."',
                '".$password."'
            )";


    if($connection->query($sql) === TRUE) {

        echo "
        <script>
            alert('New user has been created successfully!');
            window.location.href = 'users.php';
        </script>
        ";

    } else {

        echo "
        <script>
            alert('Error: " . $connection->error . "');
            window.history.back();
        </script>
        ";

    }

?>

