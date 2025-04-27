<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';
include("database.php");
session_start();

//SESSION CHECK
if (!isset($_SESSION['userID'], $_POST['resID'], $_POST['cNum'], $_POST['cName'], $_POST['totalPrice'])) {
    echo "Invalid submission.";
    exit;
}

$userID = intval($_SESSION['userID']);
$resID = intval($_POST['resID']);
$totalPrice = floatval($_POST['totalPrice']);
$cardName = htmlspecialchars(trim($_POST['cName']));
$cardNumber = preg_replace('/\D/', '', $_POST['cNum']); // Only digits
$last4 = substr($cardNumber, -4);

//INSERT PAYMENT INTO DB
$insertPayment = "INSERT INTO payments (userID, resID, amount, cardName, last4) 
                  VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insertPayment);
$stmt->bind_param("iisss", $userID, $resID, $totalPrice, $cardName, $last4);

if ($stmt->execute()) {
    //Update reservation status
    $updateRes = $conn->prepare("UPDATE reservations SET status = 'Confirmed' WHERE resID = ?");
    $updateRes->bind_param("i", $resID);
    $updateRes->execute();
} else {
    echo "Payment failed: " . $stmt->error;
    exit;
}

// FETCH USER DETAILS
$userQuery = "SELECT * FROM users WHERE userID = ?";
$stmtUser = $conn->prepare($userQuery);
$stmtUser->bind_param("i", $userID);
$stmtUser->execute();
$userResult = $stmtUser->get_result();
$user = $userResult->fetch_assoc();
if (!$user) {
    echo "User not found.";
    exit;
}

//FETCH RESERVATION DETAILS (confirmed one)
$resQuery = "SELECT reservations.*, restype.typeName, restype.resPrice 
             FROM reservations 
             JOIN restype ON reservations.resTypeID = restype.resTypeID 
             WHERE reservations.resID = ? AND reservations.userID = ?";
$stmtRes = $conn->prepare($resQuery);
$stmtRes->bind_param("ii", $resID, $userID);
$stmtRes->execute();
$resResult = $stmtRes->get_result();
$reservation = $resResult->fetch_assoc();

if (!$reservation) {
    echo "Reservation not found.";
    exit;
}

// Format reservation time
$resDate = date("m/d/Y", strtotime($reservation['resDate']));
$resStartTime = date("g:i A", strtotime($reservation['resStartTime']));
$resEndTime = date("g:i A", strtotime($reservation['resEndTime']));
// Calculate the number of hours for the reservation
$startTime = new DateTime($reservation['resStartTime']);
$endTime = new DateTime($reservation['resEndTime']);
$interval = $startTime->diff($endTime);
$hours = $interval->h + ($interval->i / 60); // Convert minutes to hours

// Round up the number of hours
$hours = ceil($hours);

// Calculate the total price (number of hours * price per hour)
$totalPrice = $hours * $reservation['resPrice'];

//SEND CONFIRMATION EMAIL
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'jessies.java.1@gmail.com';
    $mail->Password = 'szch tstb dxtn fozh';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('jessies.java.1@gmail.com', 'Jessie\'s Java');
    $mail->addAddress($user['eMail']);
    $mail->Subject = 'Jessie\'s Java - Reservation Confirmation';

    $emailBody = "
<h2>Reservation Confirmation</h2>
<p>Thank you, <b>{$user['fName']} {$user['lName']}</b>, for your reservation at Jessie's Java!</p>
<h3>Your Reservation Details:</h3>
<p><b>Reservation Type:</b> " . strtoupper($reservation['typeName']) . "</p>
<p><b>Total Price:</b> $" . number_format($totalPrice, 2) . "</p>
<p><b>Date:</b> $resDate</p>
<p><b>Time:</b> $resStartTime - $resEndTime</p>
<br>
<p>For any changes or cancellations, contact us at (404) 555-0198.</p>
<p><b>Jessie's Java</b><br>123 Java Avenue, Suite 200<br>Atlanta, GA 30303</p>
";

    $mail->isHTML(true);
    $mail->Body = $emailBody;
    $mail->send();

} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
$stmt->close();
$stmtUser->close();
$stmtRes->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jessie's Java</title>
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
            <p><b>Confirmation Number:</b> <?= htmlspecialchars((($reservation['resID']))); ?></p>
            <p><b>E-Mail Address: </b> <?= htmlspecialchars($user['eMail']); ?></p>
            <p><b>Phone Number: </b> <?= htmlspecialchars($user['phone']); ?></p>
            <p><b>Reservation Type: </b> <?= htmlspecialchars(strtoupper($reservation['typeName'])); ?></p>
            <p><b>Price:</b> $<?= number_format($totalPrice, 2); ?></p>
            <p><b>Date: </b><?= htmlspecialchars(date("m/d/Y", strtotime($reservation['resDate']))); ?></p>
            <p><b>Time: </b><?= htmlspecialchars(date("g:i A", strtotime($reservation['resStartTime']))); ?> - 
                        <?= htmlspecialchars(date("g:i A", strtotime($reservation['resEndTime']))); ?></p>
            <br>
            <small>If you have any questions or need assistance with making any changes, contact us.</small>
 
    <address class="address-container">
    <strong>Jessie's Java Address:</strong> <br>
    123 Java Avenue, Suite 200<br>
    Atlanta, GA 30303<br><br>
    <strong>Jessie's Java Phone:</strong> <br>
    (404) 555-0198
  </address>
            <p>Enjoy your Jessie's Java Coding Experience!</p>
       </div>  
        </div>
        <br>
      <button onclick="window.print()" class="no-print"> <div class="printBtn"> Print / Save as PDF</div></button> <br> <br>
      <small>You will also receive a confirmation email, so please check your spam or junk folder.</small>

        <?php include('footer.php'); ?>
        <script src="script.js"></script>
    </div>
</body>
</html>