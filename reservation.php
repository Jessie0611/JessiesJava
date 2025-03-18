<?php
include("database.php");
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
        <img src="Images/JJ-reserveHero.png" alt="Hero Image Unavailable" width="100%">
    </div>
    <hr>
    <nav>
        <button class="btn"><a href="index.html">&nbsp;&nbsp;&nbsp;&nbsp;Home &nbsp;&nbsp;&nbsp;&nbsp;</a></button>
        <button class="btn"><a href="reservation.html">Reservation</a></button>
        <button class="btn"><a href="menu.html">&nbsp;&nbsp;&nbsp;&nbsp; Menu &nbsp;&nbsp;&nbsp;&nbsp;</a></button>
        <button class="btn"> <a href="aboutus.html"> &nbsp;&nbsp;About Us&nbsp;&nbsp;</a></button>
    </nav>
<p> <h3>Reserve Your Space at Jessie's Java!</h3>
<h3>Service Options:</h3>
<b>🖥️ Computer Booth [$60.00]</b> Booths come fully equipped with a programming computer, extra monitor, headphones, keyboard, and mouse. <br> <br>
<b>💻BYOL (Bring Your Own Laptop) [$100.00]</b> A table equpied with the optional otional extra monitor, headphones, keyboard and mouse. 
<br>[Plug ins available to charge your tech]. <br>
<br>
<b>👨‍👨‍👦‍👦Collaboration Room [$200.00] </b> Looking for a more relaxed setting for your collaboration projects, away from the office grind? <br>
Our collaboration rooms are designed to provide just that, with two computer booths and space for up to eight BYOL areas,
 it's the perfect space for creative work. <br>
 <br><br><br> Additional equipment can be rented on the same day, based on availability.
</p>

    <!-- Space Type Selection-->
         <div class="section">
            <form action="database.php" method="post"...>
        <label for="spaceType">Select Your Space</label>
        <select id="spaceType" name="spaceType" required>
            <option value="">--- Select Your Space ---</option>
            <option value="compBooth">$60.00 BYOL Table</option>
            <option value="byol">$100.00 Computer Booth</option>
            <option value="collabRoom">$200.00 Collaboration Room </option>
        </select> </form>
    </div> 
         <!-- Date and Time Selection-->
         <div class="section">
            <form action="database.php" method="post">

            <label for="resDate">Reservation Date</label>
            <input type="date" id="resDate" name="resDate" required>

            <label for="resTime">Reservation Time</label>
            <input type="time" id="resTime" name="resTime" required>
            </form>
        </div>

          <!-- Personal Information-->
          <div class="section">
            <form action="database.php" method="post">

            <label for="fName">First Name </label>
            <input type="text" id="fName" name="fName" placeholder="First Name" required>
<br>
    <label for="lName">Last Name </label>
    <input type="text" id="lName" name="lName" placeholder="Last Name" required>
    <br>
            <label for="email">Email Address&nbsp;</label>
            <input type="email" id="email" name="email" placeholder="E-mail Address" required>
<br>
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Phone Number">
            </form>
        </div>
        <!-- Submit Button-->
        <button class="submit"><a href="resPayment.html">Reserve</a></button>
          </form>



          <button id="chatbotButton" onclick="toggleChatbot()">💬 Chat with Brewgle</button>
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
            
                
</div>   
               <hr>
    <script src="script.js"></script>
</body>
</html>