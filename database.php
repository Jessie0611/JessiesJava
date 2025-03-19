<?php
$host = "127.0.0.1";
$port = 3306;
$user = "root";
$password = "";
$dbname = "jessiesjava";
$conn = "";

// Create a single MySQLi connection
$conn = new mysqli($host, $user, $password, $dbname, $port);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
