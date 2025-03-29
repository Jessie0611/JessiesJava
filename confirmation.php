<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';
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
// Format Date and Time
$resDate = date("m/d/Y", strtotime($reservation['resDate']));
$resTime = date("g:i A", strtotime($reservation['resTime']));
// Send confirmation email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Use your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'jessies.java.1@gmail.com';
    $mail->Password = 'szch tstb dxtn fozh';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Email details
    $mail->setFrom('jessies.java.1@gmail.com', 'Jessie\'s Java');
    $mail->addAddress($user['eMail']); // Customer's email
    $mail->Subject = 'Jessie\'s Java - Reservation Confirmation';
    
    $emailBody = "
    <h2>Reservation Confirmation</h2>
    <p>Thank you, <b>{$user['fName']} {$user['lName']}</b>, for your reservation at Jessie's Java!</p>
    <h3>Your Reservation Details:</h3>
    <p><b>Reservation Type:</b> " . strtoupper($reservation['typeName']) . "</p>
    <p><b>Price:</b> $" . $reservation['resPrice'] . "</p>
    <p><b>Date:</b> $resDate</p>
    <p><b>Time:</b> $resTime</p>
    <br>
    <p>For any changes or cancellations, contact us at (404) 555-0198.</p>
    <br>
    <p>We look forward to seeing you!</p>
    <p><b>Jessie's Java</b></p>
    <p>123 Java Avenue, Suite 200<br>Atlanta, GA 30303</p>
    ";
    $mail->isHTML(true);
    $mail->Body = $emailBody;
    $mail->send();
} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
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
        <?php include('nav.php'); ?>

        <div class="confirm-align">
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
        </div>
        <br>
        <button onclick="window.print()" class="no-print">Print / Save as PDF</button> <br>
        <small>You will also receive a confirmation e-mail, please check your spam or junk folder.</small>

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
