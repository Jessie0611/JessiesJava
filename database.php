<?php
$host = "127.0.0.1";
$port = 3306;
$user = "root";
$password = "";
$dbname = "jessiesjava";

// Create a single MySQLi connection
$conn = new mysqli($host, $user, $password, $dbname, $port);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $resDate = $_POST['resDate'];
    $resTime = $_POST['resTime'];
    $resType = $_POST['resType'];  // Reservation type (Booth, Room, etc.)

    // Insert the user into the 'users' table first
    $stmt = $conn->prepare("INSERT INTO users (fName, lName, eMail, phoneNum, resDate, resTime) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $fullName, $fullName, $email, $phone, $resDate, $resTime);

    // Check if the query was successful
    if ($stmt->execute()) {
        $userID = $stmt->insert_id;  // Get the inserted userID
    } else {
        echo "<p>Error adding user.</p>";
        exit();
    }

    // Now insert the reservation into the 'reservations' table
    $stmt = $conn->prepare("INSERT INTO reservations (userID, resTypeID, resDate, resTime) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $userID, $resType, $resDate, $resTime);

    // Execute the query and check for success
    if ($stmt->execute()) {
        $resID = $stmt->insert_id;  // Get the inserted resID
        echo "<p>Your reservation has been successfully submitted!</p>";
    } else {
        echo "<p>Error creating reservation.</p>";
        exit();
    }

    // Optionally, handle payment here (if necessary)
    // Example: Get the price for the reservation type
    $amount = getPriceForReservationType($resType, $conn);  // Assume this function retrieves the price from the resType table

    // Insert the payment record
    $stmt = $conn->prepare("INSERT INTO payments (userID, resID, amount, paymentDate) VALUES (?, ?, ?, ?)");
    $paymentDate = date('Y-m-d');  // Get the current date
    $stmt->bind_param("iiis", $userID, $resID, $amount, $paymentDate);

    if ($stmt->execute()) {
        echo "<p>Payment has been processed.</p>";
    } else {
        echo "<p>Error processing payment.</p>";
    }

    $stmt->close();

$conn->close();
}
// Function to get the price based on the reservation type
function getPriceForReservationType($resTypeID, $conn) {
    $stmt = $conn->prepare("SELECT resPrice FROM resType WHERE resTypeID = ?");
    $stmt->bind_param("i", $resTypeID);
    $stmt->execute();
    $stmt->bind_result($resPrice);
    $stmt->fetch();
    return $resPrice;
}
?>