<?php include __DIR__ . '/../initialize.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management Dashboard</title>

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

        /* MAIN CONTENT */
        .main {
            margin-left: 220px;
            padding: 30px;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
        }

        /* CARDS */
        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            flex: 1;
        }

        .card h3 {
            margin: 0;
            color: #666;
        }

        .card p {
            font-size: 28px;
            font-weight: bold;
            margin: 10px 0 0;
        }

        /* TABLE CONTAINER */
        .table-container {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-header h2 {
            margin: 0;
        }

        /* BUTTON */
        .btn {
            display: inline-block;
            padding: 9px 15px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
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

        .btn-edit {
            background-color: #ffc107;
            color: black;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #f1f3f5;
            text-align: left;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        /* PAGINATION */
        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            display: inline-block;
            padding: 8px 13px;
            margin: 2px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #007bff;
            background-color: white;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: white;
        }

        .pagination .active {
            background-color: #007bff;
            color: white;
        }

        /* RESPONSIVE */
        @media(max-width: 700px) {

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .sidebar h2 {
                margin-bottom: 10px;
            }

            .main {
                margin-left: 0;
            }

            .cards {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <h2>User System</h2>

    <a href="api/index.php" class="active">
        Dashboard
    </a>

    <a href="api/users.php">
        Users
    </a>

    <a href="api/user_create.php">
        Create User
    </a>

</div>


<!-- MAIN CONTENT -->

<div class="main">

    <div class="header">
        <h1>Dashboard</h1>
        <p>User Management System</p>
    </div>


    <?php

        /* COUNT USERS */

        $count_query = mysqli_query(
            $connection,
            "SELECT COUNT(*) AS total FROM users"
        );

        $count_data = mysqli_fetch_assoc($count_query);

        $total_users = $count_data['total'];

    ?>


    <!-- STATISTICS -->

    <div class="cards">

        <div class="card">

            <h3>Total Users</h3>

            <p>
                <?php echo $total_users; ?>
            </p>

        </div>


        <div class="card">

            <h3>System</h3>

            <p>
                Active
            </p>

        </div>


        <div class="card">

            <h3>User Management</h3>

            <p>
                Ready
            </p>

        </div>

    </div>


    <!-- USER TABLE -->

    <div class="table-container">

        <div class="table-header">

            <h2>Users</h2>

            <a href="user_create.php" class="btn btn-primary">
                + Create User
            </a>

        </div>


        <?php

            /* PAGINATION */

            $users_per_page = 5;

            if(isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            if($page < 1) {
                $page = 1;
            }


            $start = ($page - 1) * $users_per_page;


            /* TOTAL USERS */

            $total_query = mysqli_query(
                $connection,
                "SELECT COUNT(*) AS total FROM users"
            );

            $total_data = mysqli_fetch_assoc($total_query);

            $total_users = $total_data['total'];

            $total_pages = ceil(
                $total_users / $users_per_page
            );


            /* GET USERS */

            $query = mysqli_query(
                $connection,
                "SELECT id, firstname, lastname, username
                 FROM users
                 ORDER BY id ASC
                 LIMIT $start, $users_per_page"
            );

        ?>


        <table>

            <tr>
                <th>ID</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>


            <?php

                if(mysqli_num_rows($query) > 0) {

                    while($user = mysqli_fetch_assoc($query)) {

            ?>

            <tr>

                <td>
                    <?php echo $user['id']; ?>
                </td>

                <td>
                    <?php echo $user['firstname']; ?>
                </td>

                <td>
                    <?php echo $user['lastname']; ?>
                </td>

                <td>
                    <?php echo $user['username']; ?>
                </td>

                <td>

                    <a
                        href="edit.php?id=<?php echo $user['id']; ?>"
                        class="btn btn-edit"
                    >
                        Edit
                    </a>

                    <a
                        href="delete.php?id=<?php echo $user['id']; ?>"
                        class="btn btn-delete"
                    >
                        Delete
                    </a>

                </td>

            </tr>

            <?php

                    }

                } else {

            ?>

            <tr>

                <td colspan="5" style="text-align:center;">
                    No users found.
                </td>

            </tr>

            <?php

                }

            ?>

        </table>


        <!-- PAGINATION -->

        <div class="pagination">

            <?php

                if($page > 1) {

                    echo '
                    <a href="?page=' . ($page - 1) . '">
                        Previous
                    </a>';

                }


                for($i = 1; $i <= $total_pages; $i++) {

                    if($i == $page) {

                        echo '
                        <a class="active" href="?page=' . $i . '">
                            ' . $i . '
                        </a>';

                    } else {

                        echo '
                        <a href="?page=' . $i . '">
                            ' . $i . '
                        </a>';

                    }

                }


                if($page < $total_pages) {

                    echo '
                    <a href="?page=' . ($page + 1) . '">
                        Next
                    </a>';

                }

            ?>

        </div>

    </div>

</div>

</body>
</html>

