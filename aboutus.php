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
        <img src="Images/jj-hero.png" alt="Hero Image" class="hero img"></div>
        <?php include('nav.php'); ?>

    <div class="aboutUs">
      <div class="aboutAlign">
        <p>
At Jessie's Java, we've brewed up the perfect blend of productivity and comfort for the coding community!
<br> Step into a space meticulously designed with programmers in mind, where the aroma of freshly ground coffee fuels your coding creativity. <br>
<br>🖥️ <b>Code and Coffee Unite:</b> Immerse yourself in a programming haven with dedicated computer stations equipped with the latest tech. Whether you're debugging, designing, or deep in development, our cozy nooks are tailored for optimal focus. <br>
<br>👩‍💻<b> BYOL (Bring Your Own Laptop):</b> Prefer your own coding setup? No problem! Jessie's Java welcomes your personal laptops with open arms. Plus, enjoy the luxury of extra monitors to expand your coding canvas and boost your multitasking prowess. <br>
<br>
☕ <b>Premium Brews:</b> Sip on the finest artisanal coffees, expertly crafted to keep your energy levels high and your taste buds delighted. From velvety lattes to bold espresso shots, our menu is a symphony of flavors to complement your coding journey. <br>
<br><b>🚀 Productivity Reimagined:</b> Escape the typical office grind and find inspiration in our vibrant atmosphere. Engage with fellow coders, attend coding events, and stay up-to-date with the latest tech trends. Jessie's Java is more than a coffee shop—it's a hub where innovation and caffeine collide. 
<br><br><b>🌐 Fast and Reliable Wi-Fi:</b> We understand the importance of a stable connection. Enjoy fiber-fast Wi-Fi to ensure seamless coding sessions and effortless collaboration.
<br><br>Join us at Jessie's Java, where every line of code is written with a side of exceptional coffee. Elevate your programming experience in an environment that's as dynamic as your code.
<br> Your next breakthrough awaits—sip, code, repeat! 💻☕
</p>
   
    <section class="businessHours">
    <h2>Business Hours</h2>
    <ul>
      <li><span class="day">Monday</span><span class="hours">6:00 a.m. - 10:00 p.m.</span></li>
      <li><span class="day">Tuesday</span><span class="hours">6:00 a.m. - 10:00 p.m.</span></li>
      <li><span class="day">Wednesday</span><span class="hours">6:00 a.m. - 10:00 p.m.</span></li>
      <li><span class="day">Thursday</span><span class="hours">6:00 a.m. - 10:00 p.m.</span></li>
      <li><span class="day">Friday</span><span class="hours">6:00 a.m. - 11:00 p.m.</span></li>
      <li><span class="day">Saturday</span><span class="hours">6:00 a.m. - 11:00 p.m.</span></li>
      <li><span class="day">Sunday</span><span class="hours">9:00 a.m. - 9:00 p.m.</span></li>
    </ul>
            <address class="addressContainer">
    <strong>Jessie's Java Address:</strong>
    123 Java Avenue, Suite 200<br>
    Atlanta, GA 30303<br><br>
    <strong>Jessie's Java Phone:</strong>
    (404) 555-0198
  </address>
  </section>
        <h2>Contact Us</h2>
        <form action="contact.php" method="POST">
          <input type="name" id="name" name="name" required placeholder="Your Name">
          <input type="email" id="email" name="email" required placeholder="Your Email">
          <textarea id="message" name="message" required placeholder="Your Message"></textarea>
          <button type="submit" class="submit">Send Message</button>
        </form>
      </div> </div>
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