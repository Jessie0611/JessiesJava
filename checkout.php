<?php 
session_start();
include("database.php");

//Proper session check
if (!isset($_SESSION['userID']) || empty($_SESSION['userID'])) {
    echo "Invalid request.";
    exit();
}
$userID = intval($_SESSION['userID']);
//Fetch user details
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
//Fetch latest reservation
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
// Convert times to DateTime objects
$start = new DateTime($reservation['resTime']);
$end = new DateTime($reservation['resEndTime']);

// Calculate the difference in hours
$interval = $start->diff($end);
$hours = $interval->h + ($interval->i / 60); // Includes minutes as decimals

// Round up to the nearest hour if partial
$hours = ceil($hours);

// Calculate total price
$totalPrice = $hours * $reservation['resPrice'];

if (!$reservation) {
    echo "Reservation not found.";
    exit();
}
//Format date and time
$resDate = date("m/d/Y", strtotime($reservation['resDate']));
$resTime = date("g:i A", strtotime($reservation['resTime']));
$resEndTime = date("g:i A", strtotime($reservation['resEndTime']));

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
        <div class="serviceOpt">
        <div class="resAlign">
            </h2>
            <h3>Reservation Details for  <?= htmlspecialchars($user['fName'] . " " . $user['lName']); ?>:
            </h3>
            <p><b>E-Mail Address: </b> <?= htmlspecialchars($user['eMail']); ?></p>
            <p><b>Phone Number: </b> <?= htmlspecialchars($user['phone']); ?></p>
            <p><b>Reservation Type: </b> <?= htmlspecialchars(strtoupper($reservation['typeName'])); ?></p>
            <p><strong>Price:</strong> $<?= number_format($totalPrice, 2); ?>
             (<?= $hours ?> hour<?= $hours > 1 ? 's' : '' ?> @ $<?= number_format($reservation['resPrice'], 2) ?>/hr)</p>
            <p><b>Reservation Date: </b><?= htmlspecialchars(date("m/d/Y", strtotime($reservation['resDate']))); ?></p>
            <p><b>Time: </b><?= htmlspecialchars(date("g:i A", strtotime($reservation['resTime']))); ?> - 
                        <?= htmlspecialchars(date("g:i A", strtotime($reservation['resEndTime']))); ?></p>
    <small>If you have any questions or need to make any changes contact us.</small>
 <br> <br><br>
 <form action="confirmation.php" method="POST">
    <label for="payment">Payment Information:</label> <br><br>

    <input type="text" id="cNum" name="cNum" placeholder="#### #### #### ####" maxlength="19" required
           inputmode="numeric" oninput="formatCardNumber(this)"> <br>
    <input type="month" id="expDate" name="expDate" required>
        <input type="text" id="sCode" name="sCode" placeholder="Security Code" required><br>
    <input type="text" id="cName" name="cName" placeholder="Name on card" required><br>

    <!-- You can also send hidden data like total price or userID if needed -->
    <input type="hidden" name="totalPrice" value="<?= htmlspecialchars($totalPrice); ?>">
    <input type="hidden" name="resID" value="<?= htmlspecialchars($reservation['resID']); ?>">

    <button type="submit" class="pay">Pay Now</button>
</form>
 </div>  
  
        <br>
  
            </div>
        <?php include('footer.php'); ?>
        <script src="script.js"></script>
    </div>              

</body>
</html>