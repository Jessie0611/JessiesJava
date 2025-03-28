<?php 
include("database.php");
if (!isset($_GET['userID']) || empty($_GET['userID'])) {
    echo "Invalid request.";
    exit();
}

$userID = intval($_GET['userID']);

// Fetch user details
$userQuery = "SELECT * FROM users WHERE userID = ?";
$stmtUser = $conn->prepare($userQuery);
$stmtUser->bind_param("i", $userID);
$stmtUser->execute();
$userResult = $stmtUser->get_result();
$user = $userResult->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}
// Fetch reservation details
$resQuery = "SELECT reservations.*, restype.typeName FROM reservations 
             JOIN restype ON reservations.resTypeID = restype.resTypeID 
             WHERE userID = ? ORDER BY resID DESC LIMIT 1";
$stmtRes = $conn->prepare($resQuery);
$stmtRes->bind_param("i", $userID);
$stmtRes->execute();
$resResult = $stmtRes->get_result();
$reservation = $resResult->fetch_assoc();

if (!$reservation) {
    echo "Reservation not found.";
    exit();
}
$resQuery = "SELECT reservations.*, restype.typeName, restype.resPrice 
             FROM reservations 
             JOIN restype ON reservations.resTypeID = restype.resTypeID 
             WHERE userID = ? 
             ORDER BY resID DESC LIMIT 1";
$stmtRes = $conn->prepare($resQuery);
$stmtRes->bind_param("i", $userID);
$stmtRes->execute();
$resResult = $stmtRes->get_result();
$reservation = $resResult->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jessie's Java Confirmation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="content">
        <div class="hero">
            <img src="Images/JJ-resPaymentHero.png" alt="Hero Image Unavailable" width="100%">
        </div>
        <nav class="no-print">
            <button class="btn"><a href="index.php">Home</a></button>
            <button class="btn"><a href="reservation.php">Reservation</a></button>
            <button class="btn"><a href="menu.php">Menu</a></button>
            <button class="btn"><a href="aboutus.php">About Us</a></button>
        </nav>
        <hr>
        <div class="confirmation-container">
            <h2>You have successfully reserved your space!<br><br>
            Thank you, <?= htmlspecialchars($user['fName'] . " " . $user['lName']); ?>!
            </h2>
            <h3>Your reservation details:</h3>
            <p><b>E-Mail Address: </b> <?= htmlspecialchars($user['eMail']); ?></p>
            <p><b>Phone Number: </b> <?= htmlspecialchars($user['phone']); ?></p>
            <p><b>Reservation Type: </b> <?= htmlspecialchars(strtoupper($reservation['typeName'])); ?></p>
            <p><strong>Price:</strong> $<?= htmlspecialchars($reservation['resPrice']); ?></p>
            <p><b>Date: </b><?= htmlspecialchars(date("m/d/Y", strtotime($reservation['resDate']))); ?></p>
            <p><b>Time: </b><?= htmlspecialchars(date("g:i A", strtotime($reservation['resTime']))); ?></p>
            <br>
    <small>If you have any questions or need to make any changes contact us.</small>
 
    <address class="address-container">
    <strong>Jessie's Java Address:</strong>
    123 Java Avenue, Suite 200<br>
    Atlanta, GA 30303<br><br>
    <strong>Jessie's Java Phone:</strong>
    (404) 555-0198
  </address>
            <p>Enjoy your Jessie's Java Coding Experience!</p>
         
        </div>
        <button onclick="window.print()" class="no-print">Print / Save as PDF</button>

        <button id="chatbotButton" class="no-print" onclick="toggleChatbot()">💬 Brewgle</button>
        <div id="chatbotContainer" class="no-print">
            <div id="chatbotHeader" onclick="toggleChatbot()">💬 Close Brewgle  &nbsp;&nbsp;&nbsp;&nbsp; ✖</div>
            <iframe id="chatbotiFrame" title="Brewgle" src="https://jessiesjava.ai.copilot.live"
                style="border:none;" loading="lazy"
                allow="microphone;camera;speaker;clipboard-read;clipboard-write;geolocation;"
                width="400px" height="540px"></iframe>
        </div>
        <footer class="footer no-print">
            <div class="socialLinks">
                <a href="https://www.facebook.com" target="_blank" class="socialLink">
                    <img src="Images/facebook.jpg" class="socialIcon">
                </a>
                <a href="https://www.instagram.com" target="_blank" class="socialLink">
                    <img src="Images/insta.jpg" class="socialIcon">
                </a>
            </div>
            <hr>
        </footer>
    </div>
    <script src="script.js"></script>
</body>
</html>
