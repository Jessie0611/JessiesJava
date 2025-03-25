<?php include("database.php"); ?>
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
        <img src="Images/jj-menuhero.png" alt="Hero Image" class="hero img"></div>
<hr>
        <nav>
        <button class="btn"><a href="index.php">&nbsp;&nbsp;&nbsp;Home &nbsp;&nbsp;&nbsp;</a></button>
            <button class="btn"><a href="reservation.php">Reservation</a></button>
            <button class="btn"><a href="menu.php">&nbsp;&nbsp;&nbsp; Menu &nbsp;&nbsp;&nbsp;</a></button>
            <button class="btn"> <a href="aboutus.php"> &nbsp;About Us&nbsp;</a></button>
           </nav>
      
               <h2>Welcome to the Coffee Shop!</h2>
               <h3>Choose your drink type:</h3>
               
               <select id="drinkType" onchange="showMenu()">
                   <option value="">-- Select Drink Type --</option>
                   <option value="hotLattes">Hot Lattes</option>
                   <option value="icedLattes">Iced Lattes</option>
                   <option value="hotEspresso">Hot Espresso Drinks</option>
                   <option value="icedEspresso">Iced Espresso Drinks</option>
               </select>
           <br>
           <hr>
           <br>
               <div id="menu" class="menu-section"></div>
           <br>
           <hr>
           </body>
           </html>
           
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
                </footer>
             <hr>    
</div>
    <script src="script.js"></script>
</body>
</html>