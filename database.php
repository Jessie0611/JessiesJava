<?php
// Database connection parameters
$host="127.0.0.1";
$port=3306;
$socket="";
$user="root";
$password="";
$dbname="jessiesjava";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());

//$con->close();

$conn = new mysqli($host, $username, $password, $dbname);

//Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $space = $_POST['spaceType'];
    $resDate = $_POST['resDate'];
    $resTime = $_POST['resTime'];
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $specialRequests = $_POST['specialRequests'];

    // Prepare an SQL statement to insert the reservation into the database
    $stmt = $conn->prepare("INSERT INTO reservations (spaceType, resDate, resTime, fullName, email, phone, specialRequests) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $space, $resDate, $resTime, $fullName, $email, $phone, $specialRequests);

    // Execute the query
    if ($stmt->execute()) {
        echo "<p>Your reservation has been successfully submitted!</p>";
    } else {
        echo "<p>There was an error submitting your reservation. Please try again.</p>";
    }

    $stmt->close();
    $conn->close();
}
/*  SQL DATABASE TABLE FOR RESERVATIONS:
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    spaceType VARCHAR(100),
    resDate DATE,
    resTime TIME,
    fullName VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(50),
    specialRequests TEXT
);
 
SQL DATABASE TABLE FOR USERS:
CREATE TABLE USERS (
    userID primary key,
    fullName VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(50),
);

SQL CREATE DATABASE FOR AVAILABLE:

 */
?>