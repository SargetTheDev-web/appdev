<?php
include 'initialize.php';

if (!isset($_GET['id'])) {
    header('Location: users.php');
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM users WHERE id = '$id'";
$result = $connection->query($sql);

if ($result->num_rows == 0) {
    echo "<script>
            alert('User not found!');
            window.location.href = 'users.php';
          </script>";
    exit();
}

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 220px;
            height: 100vh;
            background: #1f2937;
            padding: 25px 15px;
        }

        .sidebar h2 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: #d1d5db;
            text-decoration: none;
            padding: 13px 15px;
            margin-bottom: 8px;
            border-radius: 6px;
        }

        .sidebar a:hover {
            background: #374151;
            color: white;
        }

        .main-content {
            margin-left: 220px;
            padding: 40px;
        }

        .form-container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        h1 {
            margin-top: 0;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .buttons {
            margin-top: 25px;
            display: flex;
            gap: 10px;
        }

        button {
            border: none;
            padding: 11px 20px;
            border-radius: 6px;
            cursor: pointer;
        }

        .save-btn {
            background: #2563eb;
            color: white;
        }

        .cancel-btn {
            background: #e5e7eb;
            color: #111827;
            text-decoration: none;
            padding: 11px 20px;
            border-radius: 6px;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <h2>User Admin</h2>

    <a href="index.php">Dashboard</a>
    <a href="users.php">Users</a>
    <a href="user_create.php">Create User</a>
</div>

<div class="main-content">

    <div class="form-container">

        <h1>Edit User</h1>

        <form action="user_edit_data.php" method="POST">

            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

            <label>Firstname</label>
            <input type="text" name="firstname"
                   value="<?php echo $user['firstname']; ?>" required>

            <label>Lastname</label>
            <input type="text" name="lastname"
                   value="<?php echo $user['lastname']; ?>" required>

            <label>Username</label>
            <input type="text" name="username"
                   value="<?php echo $user['username']; ?>" required>

            <label>Password</label>
            <input type="text" name="password"
                   value="<?php echo $user['password']; ?>" required>

            <div class="buttons">
                <button type="submit" class="save-btn">
                    Update User
                </button>

                <a href="users.php" class="cancel-btn">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>

</body>
</html>