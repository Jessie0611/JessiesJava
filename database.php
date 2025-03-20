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
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST['fName'], $_POST['lName'], $_POST['email'], $_POST['phone'], $_POST['resDate'], $_POST['resTime'], $_POST['resType'])
        && !empty($_POST['fName']) && !empty($_POST['email'])
    ) {
        $fName = trim($_POST['fName']);
        $lName = trim($_POST['lName']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $resDate = trim($_POST['resDate']);
        $resTime = trim($_POST['resTime']);
        $resType = (int)$_POST['resType'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<p>Error: Invalid email format.</p>";
            $conn->close();
            exit();
        }

// Insert into reservations table
$stmt = $conn->prepare("INSERT INTO reservations (fName, lName, email, phone, resDate, resTime, spaceType) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $fName, $lName, $email, $phone, $resDate, $resTime, $spaceType);


// Redirect to the confirmation page

if ($stmt->execute()) {
    header("Location: confirmation.php?fName=" . urlencode($fName) . "&lName=" . urlencode($lName) . "&email=" . urlencode($email) . "&phone=" . urlencode($phone) . "&resDate=" . urlencode($resDate) . "&resTime=" . urlencode($resTime) . "&resType=" . urlencode($resType));
    exit(); //stop further code execution.
} else {
    echo "<p>Error creating reservation: " . $stmt->error . "</p>";
}
$stmt->close();
} else {
echo "<p>Error: All required fields must be filled.</p>";
}
$conn->close();
}
?>