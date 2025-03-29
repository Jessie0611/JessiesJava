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
        <img src="Images/jj-hero.png" alt="Hero Image" class="hero img"></div>
        <?php include('nav.php'); ?>
        <div class="calendar-container">
            <br>
            <br>
            <div class="calendar-header">
              <button id="prev-month">&lt;</button>
              <h2 id="month-year"></h2>
              <button id="next-month">&gt;</button>
              <br>
            </div>
        
            <table id="calendar">
              <thead>
                <tr>
                  <th>Sun</th>
                  <th>Mon</th>
                  <th>Tue</th>
                  <th>Wed</th>
                  <th>Thu</th>
                  <th>Fri</th>
                  <th>Sat</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
        
            <div class="upcoming-events">
              <h3>Upcoming Events</h3>
              <ul id="events-list"></ul>
            </div>
          </div>
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