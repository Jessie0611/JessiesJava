<?php include("database.php");
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

// If user does not exist, show error
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

// If reservation does not exist, show error
if (!$reservation) {
    echo "Reservation not found.";
    exit();
}
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
    <nav>
        <button class="btn"><a href="index.php">&nbsp;&nbsp;&nbsp;Home &nbsp;&nbsp;&nbsp;</a></button>
        <button class="btn"><a href="reservation.php">Reservation</a></button>
        <button class="btn"><a href="menu.php">&nbsp;&nbsp;&nbsp; Menu &nbsp;&nbsp;&nbsp;</a></button>
        <button class="btn"> <a href="aboutus.php"> &nbsp;About Us&nbsp;</a></button>
    </nav>
    <br>
<hr>
<br>
    <div class="confirmation-container">
        <h2>You have successfully reserved your space! <br><br>
        Thank you, <?php echo htmlspecialchars($user['fName'] . " " . $user['lName']); ?>!
    </h2>

<h3>Your reservation details:</h3>
<p><strong>Email:</strong> <?= htmlspecialchars($user['eMail']); ?></p>
<p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']); ?></p>
<p><strong>Reservation Type:</strong> <?= htmlspecialchars($reservation['typeName']); ?></p>
<p><strong>Date:</strong> <?= htmlspecialchars($reservation['resDate']); ?></p>
<p><strong>Time:</strong> <?= htmlspecialchars($reservation['resTime']); ?></p>
<br><br>
<p>Enjoy your Jessie's Java Coding Experience!</p>
    <br>
    <button id="chatbotButton" onclick="toggleChatbot()">💬 Brewgle</button>
    <div id="chatbotContainer">
        <div id="chatbotHeader" onclick="toggleChatbot()">💬 Close Brewgle  &nbsp;&nbsp;&nbsp;&nbsp; ✖<span id="close-chatbot" onclick="toggleChatbot()">
        </span></div>
         <iframe
           id="chatbotiFrame"
           title="Brewgle"
           src="https://jessiesjava.ai.copilot.live"
           style="border:none;"
           loading="lazy"
           allow="microphone;camera;speaker;clipboard-read;clipboard-write;geolocation;"
           width="400px"
           height="540px"
        ></iframe>
    </div>
<br>
         <footer class="footer">
             <div class="socialLinks">
               <a href="https://www.facebook.com" target="_blank" class="socialLink">
                 <img src="Images/facebook.jpg" class="socialIcon"></a>
             <a href="https://www.instagram.com" target="_blank" class="socialLink">
               <img src="Images/insta.jpg" class="socialIcon">
           </div>
           <hr>
         </footer>
    <script src="script.js"></script>
</body>
</html>