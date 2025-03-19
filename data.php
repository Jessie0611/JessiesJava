<?php
include("database.php");
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
        $resType = (int)$_POST['resType']; // Ensure it's an integer

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<p>Error: Invalid email format.</p>";
            $conn->close();
            exit();
        }

// Insert into reservations table
$stmt = $conn->prepare("INSERT INTO reservations (fName, lName, email, phone, resDate, resTime, spaceType) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $fName, $lName, $email, $phone, $resDate, $resTime, $spaceType);

if ($stmt->execute()) {
    // Redirect to the confirmation page with necessary query parameters (including name, reservation date, time, and space type)
    header("Location: confirmation.php?name=" . urlencode($fName) . "&resDate=" . urlencode($resDate) . "&resTime=" . urlencode($resTime) . "&spaceType=" . urlencode($spaceType));
    exit(); // Don't forget to call exit() after header redirect to stop further code execution.
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