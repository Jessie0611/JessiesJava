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
        <?php include('nav.php'); ?>

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
           <br>
               <div id="menu" class="menu-section"></div>
           <br>
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
      <?php include('footer.php'); ?>
    <script src="script.js"></script>
</body>
</html>