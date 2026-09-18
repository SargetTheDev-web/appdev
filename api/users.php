<?php include __DIR__ . '/../initialize.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Users</title>

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
            max-width: 1100px;
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

        /* TOOLBAR */

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 15px;
        }

        .search-box {
            display: flex;
            gap: 5px;
        }

        .search-box input {
            padding: 10px;
            width: 280px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* BUTTONS */

        .btn {
            display: inline-block;
            padding: 9px 15px;
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

        .btn-edit {
            background-color: #ffc107;
            color: black;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        /* TABLE */

        .table-container {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #f1f3f5;
            text-align: left;
        }

        th,
        td {
            padding: 13px;
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

        .user-count {
            color: #666;
            margin-bottom: 15px;
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

            .toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                width: 100%;
            }

            .search-box input {
                width: 100%;
            }

            .table-container {
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <h2>User System</h2>

    <a href="index.php">
        Dashboard
    </a>

    <a href="users.php" class="active">
        Users
    </a>

    <a href="user_create.php">
        Create User
    </a>

</div>


<!-- MAIN -->

<div class="main">

    <div class="main-content">

        <div class="header">

            <h1>Users</h1>

            <p>Manage all registered users.</p>

        </div>


        <?php

            /* SEARCH */

            if(isset($_GET['search'])) {

                $search = $_GET['search'];

            } else {

                $search = '';

            }


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


            /* SEARCH CONDITION */

            if($search != '') {

                $search_safe = mysqli_real_escape_string(
                    $connection,
                    $search
                );

                $where = "
                    WHERE firstname LIKE '%$search_safe%'
                    OR lastname LIKE '%$search_safe%'
                    OR username LIKE '%$search_safe%'
                ";

            } else {

                $where = '';

            }


            /* COUNT */

            $count_query = mysqli_query(
                $connection,
                "SELECT COUNT(*) AS total
                 FROM users
                 $where"
            );

            $count_data = mysqli_fetch_assoc($count_query);

            $total_users = $count_data['total'];

            $total_pages = ceil(
                $total_users / $users_per_page
            );


            if($total_pages > 0 && $page > $total_pages) {

                $page = $total_pages;

            }


            $start = ($page - 1) * $users_per_page;


            /* GET USERS */

            $query = mysqli_query(
                $connection,
                "SELECT id, firstname, lastname, username
                 FROM users
                 $where
                 ORDER BY id ASC
                 LIMIT $start, $users_per_page"
            );

        ?>


        <!-- TOOLBAR -->

        <div class="toolbar">

            <form method="GET" class="search-box">

                <input
                    type="text"
                    name="search"
                    placeholder="Search users..."
                    value="<?php echo htmlspecialchars($search); ?>"
                >

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Search
                </button>

            </form>


            <a
                href="user_create.php"
                class="btn btn-primary"
            >
                + Create User
            </a>

        </div>


        <!-- TABLE -->

        <div class="table-container">

            <div class="user-count">

                Total Users:
                <strong>
                    <?php echo $total_users; ?>
                </strong>

            </div>


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
                        <?php echo htmlspecialchars($user['firstname']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($user['lastname']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($user['username']); ?>
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
                            onclick="return confirm('Are you sure you want to delete this user?');"
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

                    <td
                        colspan="5"
                        style="text-align:center;"
                    >
                        No users found.
                    </td>

                </tr>

                <?php

                    }

                ?>

            </table>


            <!-- PAGINATION -->

            <?php if($total_pages > 1) { ?>

            <div class="pagination">

                <?php

                    if($page > 1) {

                        echo '
                        <a href="?page=' . ($page - 1) . '&search=' . urlencode($search) . '">
                            Previous
                        </a>';

                    }


                    for($i = 1; $i <= $total_pages; $i++) {

                        if($i == $page) {

                            echo '
                            <a
                                class="active"
                                href="?page=' . $i . '&search=' . urlencode($search) . '"
                            >
                                ' . $i . '
                            </a>';

                        } else {

                            echo '
                            <a
                                href="?page=' . $i . '&search=' . urlencode($search) . '"
                            >
                                ' . $i . '
                            </a>';

                        }

                    }


                    if($page < $total_pages) {

                        echo '
                        <a href="?page=' . ($page + 1) . '&search=' . urlencode($search) . '">
                            Next
                        </a>';

                    }

                ?>

            </div>

            <?php } ?>

        </div>

    </div>

</div>

</body>
</html>
