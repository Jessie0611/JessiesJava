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
    <p>If you have any questions or concerns, please don't hesitate to contact us. <br> We're here to help and ensure your experience is smooth and enjoyable.</p>
        <h2>Contact Us</h2>
        <form action="contact.php" method="POST">
          <input type="name" id="name" name="name" required placeholder="Your Name">
          <input type="email" id="email" name="email" required placeholder="Your Email">
          <textarea id="message" name="message" required placeholder="Your Message"></textarea>
          <button type="submit" class="submit">  Send </button>
        </form>
      </div> </div>
 <br>
 <?php include('footer.php'); ?>
    <script src="script.js"></script>
</div>
</body>
</html>