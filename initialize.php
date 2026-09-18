<?php

session_start();

/*
|--------------------------------------------------------------------------
| Load .env file
|--------------------------------------------------------------------------
*/

$envFile = __DIR__ . "/.env";

if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        $line = trim($line);

        // Ignore comments
        if ($line === "" || str_starts_with($line, "#")) {
            continue;
        }

        [$key, $value] = array_pad(explode("=", $line, 2), 2, "");

        $key = trim($key);
        $value = trim($value);

        putenv("$key=$value");
    }
}

/*
|--------------------------------------------------------------------------
| Database configuration
|--------------------------------------------------------------------------
*/

$host = getenv("DB_HOST");
$port = getenv("DB_PORT");
$user = getenv("DB_USER");
$password = getenv("DB_PASSWORD");
$database = getenv("DB_NAME");

/*
|--------------------------------------------------------------------------
| Connect to Aiven MySQL
|--------------------------------------------------------------------------
*/

$connection = mysqli_init();

mysqli_ssl_set(
    $connection,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
);

if (!mysqli_real_connect(
    $connection,
    $host,
    $user,
    $password,
    $database,
    $port,
    NULL,
    MYSQLI_CLIENT_SSL
)) {
    die("Connection failed: " . mysqli_connect_error());
}

$connection->set_charset("utf8mb4");

?>