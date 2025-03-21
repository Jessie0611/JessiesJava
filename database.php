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
        $resType = (int)$_POST['resType']; // Fix variable usage

        // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p>Error: Invalid email format.</p>";
        $conn->close();
        exit();
    }

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

    if ($stmt->num_rows == 0) { // If email does not exist, insert new user
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO users (fName, lName, email, phone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fName, $lName, $email, $phone);
        $stmt->execute();
        $stmt->close();
    }

        // Insert into users table
        $stmt = $conn->prepare("INSERT INTO users (fName, lName, email, phone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fName, $lName, $email, $phone);
        $stmt->execute();
        $stmt->close(); // Close the statement to avoid conflicts

        // Insert into reservations table
        $stmt = $conn->prepare("INSERT INTO reservations (resTypeID, resDate, resTime) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $resType, $resDate, $resTime); // Fix data types: "iss"
        $success = $stmt->execute(); // Store execution result
        $stmt->close();

        // Redirect if successful
    if ($success) {
        header("Location: /JessiesJava/confirmation.php?fName=" . urlencode($fName) . "&lName=" . urlencode($lName) . "&email=" . urlencode($email) . "&phone=" . urlencode($phone) . "&resDate=" . urlencode($resDate) . "&resTime=" . urlencode($resTime) . "&resType=" . urlencode($resType));
        exit();
    } else {
        echo "<p>Error creating reservation: " . $conn->error . "</p>";
    }
    } else {
        echo "<p>Error: All required fields must be filled.</p>";
    }
    $conn->close();
}
?>