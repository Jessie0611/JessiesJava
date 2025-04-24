<?php
/*This script connects to a MySQL database using MySQLi (MySQL Improved) in PHP.
It also sets up some configurations for debugging and character encoding.*/

// Enable error reporting for debugging - tells PHP to throw errors as exceptions for any MySQLi problems
// (instead of failing silently or just returning false).
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

define('DB_HOST', 'localhost'); 
define('DB_USER', 'jessie');
define('DB_PASS', 'java123');
define('DB_NAME', 'jessiesjava');

// Create a MySQLi connection, $conn is to interact with the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// Set the character set to UTF-8
$conn->set_charset("utf8mb4");

// Check for a connection error, if connection fails, kill script and print error msg
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

?>
