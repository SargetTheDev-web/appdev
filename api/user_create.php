<?php include __DIR__ . '/../initialize.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Create New User</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
        }

        /* SIDEBAR */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 220px;
            height: 100vh;
            background-color: #222;
            color: white;
            padding-top: 25px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            padding: 14px 20px;
            color: white;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #444;
        }

        .sidebar a.active {
            background-color: #007bff;
        }

        /* MAIN */

        .main {
            margin-left: 220px;
            padding: 40px 30px;
            min-height: 100vh;
        }

        .main-content {
            max-width: 700px;
            margin: 0 auto;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
        }

        .header p {
            color: #666;
        }

        /* FORM */

        .form-container {
            background-color: white;
            padding: 35px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .form-container h2 {
            margin-top: 0;
        }

        .form-container > p {
            color: #666;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #007bff;
        }

        /* BUTTONS */

        .buttons {
            margin-top: 25px;
        }

        .btn {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 5px;
            border: none;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0069d9;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            margin-left: 5px;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        /* ALERT */

        .alert {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #e9ecef;
        }

        /* MOBILE */

        @media(max-width: 700px) {

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .main-content {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <h2>User System</h2>

    <a href="api/index.php">
        Dashboard
    </a>

    <a href="api/users.php">
        Users
    </a>

    <a href="user_create.php" class="active">
        Create User
    </a>

</div>


<!-- MAIN -->

<div class="main">

    <div class="main-content">

        <div class="header">

            <h1>Create New User</h1>

            <p>Add a new user to the system.</p>

        </div>


        <?php

            if(isset($_SESSION['alert_message'])) {

                echo '
                <div class="alert">
                    ' . $_SESSION['alert_message'] . '
                </div>
                ';

                unset($_SESSION['alert_message']);

            }

        ?>


        <!-- FORM -->

        <div class="form-container">

            <h2>User Information</h2>

            <p>
                Enter the information below to create a new user.
            </p>


            <br>


            <form
                method="POST"
                action="user_add_data.php"
            >

                <div class="form-group">

                    <label>Firstname</label>

                    <input
                        type="text"
                        name="firstname"
                        placeholder="Enter firstname"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Lastname</label>

                    <input
                        type="text"
                        name="lastname"
                        placeholder="Enter lastname"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Username</label>

                    <input
                        type="text"
                        name="username"
                        placeholder="Enter username"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Password</label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Enter password"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Confirm Password</label>

                    <input
                        type="password"
                        name="confirm_password"
                        placeholder="Confirm password"
                        required
                    >

                </div>


                <div class="buttons">

                    <button
                        type="submit"
                        name="register"
                        class="btn btn-primary"
                    >
                        Create User
                    </button>


                    <a
                        href="users.php"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>
