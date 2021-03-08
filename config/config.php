<?php
/* Database credentials. MySQL server with default setting (user 'root' with '123456' password) */

$DB_DSN = "mysql:dbname=camagru;host=127.0.0.1";
$DB_USER = "root";
$DB_PASSWORD = "123456";
$DB_DSN_NO_DB = "mysql:host=127.0.0.1";

/* Attempt to connect to MySQL database */
try
{
    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    die("ERROR: Could not connect. " . $e->getMessage());
}
