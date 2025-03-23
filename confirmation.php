<?php
session_start();

include("database.php");
echo "<pre>";
print_r($_POST);  // Check what values are being sent
echo "</pre>";
exit();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmation</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="confirmation-container">
        <h1>Reservation Confirmed</h1>
        <p>Thank you, <strong><?php echo htmlspecialchars($reservation['fName'] . " " . $reservation['lName']); ?></strong>!</p>
        <p>Your reservation details:</p>
        <ul>
            <li><strong>Email:</strong> <?php echo htmlspecialchars($reservation['eMail']); ?></li>
            <li><strong>Phone:</strong> <?php echo htmlspecialchars($reservation['phoneNum']); ?></li>
            <li><strong>Reservation Type:</strong> <?php echo htmlspecialchars($reservation['typeName']); ?></li>
            <li><strong>Date:</strong> <?php echo htmlspecialchars($reservation['resDate']); ?></li>
            <li><strong>Time:</strong> <?php echo htmlspecialchars($reservation['resTime']); ?></li>
            <li><strong>Total Amount:</strong> $<?php echo number_format($reservation['totalAmount'], 2); ?></li>
            <li><strong>Status:</strong> <?php echo htmlspecialchars($reservation['status']); ?></li>
        </ul>
        <a href="index.php">Return to Home</a>
    </div>
</body>
</html>

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
        <img src="Images/JJ-resPaymentHero.png" alt="Hero Image" class="hero img">
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
    <h2>You have successfully reserved your space!</h2>
    <h2>Enjoy your Jessie's Java Coding Experience!</h2>
    <br>
    <h2>Thank you, <?php echo htmlspecialchars($reservation['fName']); ?>!</h2>
    <p>Your reservation has been confirmed.</p>
    <ul>
        <li><strong>Name:</strong> <?php echo htmlspecialchars($reservation['fName'] . " " . $reservation['lName']); ?></li>
        <li><strong>Email:</strong> <?php echo htmlspecialchars($reservation['eMail']); ?></li>
        <li><strong>Phone:</strong> <?php echo htmlspecialchars($reservation['phoneNum']); ?></li>
        <li><strong>Type:</strong> <?php echo htmlspecialchars($reservation['typeName']); ?></li>
        <li><strong>Date:</strong> <?php echo htmlspecialchars($reservation['resDate']); ?></li>
        <li><strong>Time:</strong> <?php echo htmlspecialchars($reservation['resTime']); ?></li>
        <li><strong>Total Amount:</strong> $<?php echo number_format($reservation['totalAmount'], 2); ?></li>
        <li><strong>Status:</strong> <?php echo htmlspecialchars($reservation['status']); ?></li>


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