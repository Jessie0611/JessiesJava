<?php
session_start();
include("database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['fName'], $_POST['lName'], $_POST['email'], $_POST['phone'], $_POST['resDate'], $_POST['resTime'], $_POST['resType'])) {
        $fName = trim($_POST['fName']);
        $lName = trim($_POST['lName']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $resDate = trim($_POST['resDate']);
        $resTime = trim($_POST['resTime']);
        $resType = (int)$_POST['resType'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<p>Error: Invalid email format.</p>";
            exit();
        }

        // Store session data
        $_SESSION['name'] = $fName . ' ' . $lName;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;
        $_SESSION['resDate'] = $resDate;
        $_SESSION['resTime'] = $resTime;
        $_SESSION['resType'] = $resType;

        // Insert data into database
        $conn->begin_transaction();
        try {
            // Check if user exists
            $stmt = $conn->prepare("SELECT userID FROM users WHERE eMail = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 0) {
                $stmt->close();
                $stmt = $conn->prepare("INSERT INTO users (fName, lName, eMail, phoneNum) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $fName, $lName, $email, $phone);
                $stmt->execute();
                $userID = $stmt->insert_id;
                $stmt->close();
            } else {
                $stmt->bind_result($userID);
                $stmt->fetch();
                $stmt->close();
            }

            // Get reservation price
            $stmt = $conn->prepare("SELECT resPrice FROM restype WHERE resTypeID = ?");
            $stmt->bind_param("i", $resType);
            $stmt->execute();
            $stmt->bind_result($totalAmount);
            $stmt->fetch();
            $stmt->close();

            if (!$totalAmount) {
                throw new Exception("Invalid reservation type.");
            }

            // Insert reservation
            $status = "Pending";
            $stmt = $conn->prepare("INSERT INTO reservations (userID, resTypeID, resDate, resTime, totalAmount, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissds", $userID, $resType, $resDate, $resTime, $totalAmount, $status);
            $stmt->execute();
            $resID = $stmt->insert_id;
            $stmt->close();

            $conn->commit();

            // Redirect to confirmation page
            header("Location: confirmation.php?resID=" . urlencode($resID));
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        echo "<p>Error: Missing required fields.</p>";
        exit();
    }
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
        <img src="Images/JJ-reserveHero.png" alt="Hero Image" class="hero img">
    </div>
    <hr>
    <nav>
    <button class="btn"><a href="index.php">&nbsp;&nbsp;&nbsp;Home &nbsp;&nbsp;&nbsp;</a></button>
            <button class="btn"><a href="reservation.php">Reservation</a></button>
            <button class="btn"><a href="menu.php">&nbsp;&nbsp;&nbsp; Menu &nbsp;&nbsp;&nbsp;</a></button>
            <button class="btn"> <a href="aboutus.php"> &nbsp;About Us&nbsp;</a></button>

    </nav>
<p> <h3>Reserve Your Space at Jessie's Java!</h3>
<h3>Service Options:</h3></p>
<div class="serviceOpt">
  <p> <b>💻BYOL (Bring Your Own Laptop) [$60.00]</b><br> A table equpied with the optional otional extra monitor, headphones, keyboard and mouse. 
 <br><br>
<b>🖥️ Computer Booth [$100.00]</b><br> Booths come fully equipped with a programming computer, extra monitor, headphones, keyboard, and mouse. <br> 
<br><br>
<b>👨‍👨‍👦‍👦Collaboration Room [$200.00] </b> <br>Looking for a more relaxed setting for your collaboration projects, away from the office grind? <br>
Our collaboration rooms are designed to provide just that, with two computer booths and space for up to eight BYOL areas,
 it's the perfect space for creative work. <br><br>
</p> 
    </div>

    <form action="reservation.php" method="POST">
    <label for="resTypeID">Select Your Space</label>
    <select id="resTypeID" name="resTypeID" required>
        <option value="">--- Select Your Space ---</option>
        <option value="1">($60.00) BYOL Table</option>
        <option value="2">($100.00) Computer Booth</option>
        <option value="3">($200.00) Collaboration Room</option>
    </select> 

    <label for="resDate">Reservation Date</label>
    <input type="date" id="resDate" name="resDate" required>

    <label for="resTime">Reservation Time</label>
    <input type="time" id="resTime" name="resTime" required>

    <label for="fName">First Name</label>
    <input type="text" id="fName" name="fName" placeholder="First Name" required>

    <label for="lName">Last Name</label>
    <input type="text" id="lName" name="lName" placeholder="Last Name" required>

    <label for="email">Email Address</label>
    <input type="email" id="email" name="email" placeholder="E-mail Address" required>

    <label for="phone">Phone Number</label>
    <input type="tel" id="phone" name="phone" placeholder="Phone Number">
<div class="container">
    <p>Please read the disclosure agreement and check the box to continue. <br> 
<small>This Disclosure Agreement is made between Jessie's Java and the customers regarding the use of our <br> computer booth tables, bring-your-own-laptop (BYOL) tables, and collaboration rooms,
     along with the rental of additional technology based on availability. <br> By using our services, you acknowledge and agree to the terms outlined in this Agreement.</small>

    </p>

    <label>        <input type="checkbox" id="agreeCheckbox">
        I have read the disclosure agreement
    </label>
</div>

<div class="accordion">
    <div class="accordion-item">
        <button class="accordion-header">Disclosure Agreement</button>
        <div class="accordion-content">
             <small>
                Reservations & Walk-Ins <br>
Customers may reserve a BYOL table, computer booth, or collaboration room in advance via our website, phone, or in person. Walk-ins are welcome, but availability is not guaranteed. 
Prepaid Reservations: Customers who pay for their reservation upfront will have their table or room held for the full reservation period.
Non-Prepaid Reservations (Made In-House): Customers who make a reservation without prepayment will have their table or room held for 15 minutes (BYOL tables and computer booths). If the customer fails to arrive within the hold time, the reservation will be forfeited, and the space will be made available to walk-in customers.
Collaboration Rooms: Due to limited availability, collaboration rooms must be prepaid at the time of booking.
   <br> <br>
                Rental of Additional Tech Equipment <br>
Customers may rent extra tech accessories (e.g., monitors, keyboards, mice, chargers) based on availability.
Rental fees must be paid upfront, and certain high-value items may require a security deposit.
Customers are responsible for returning rented equipment in the same condition. Any damage or loss will result in additional fees.
<br> <br>
                Cancellation & No-Show Policy <br>
Prepaid Reservations: Cancellations must be made at least 2 hours before the reservation time for BYOL tables & computer booths and at least 4 hours before the reservation time for collaboration rooms to receive a full refund.
Cancellations made after the respective window will result in no refund. Failure to cancel or show up within the hold time will result in forfeiting the reservation, and no refund will be issued.
Non-Prepaid Reservations (Made In-House): Please cancel at least 2 hours before the reservation time for BYOL tables & computer booths if you need to cancel.
<br> <br>
                Customer Responsibilities <br>
Customers must use all facilities and equipment responsibly.
No unauthorized software downloads or modifications are allowed on provided computer booths. Customers must comply with all shop policies, including food and drink restrictions near electronic devices.
Any disruptive behavior (e.g., excessive noise, inappropriate tech use) may result in removal from the premises.
<br> <br>
Liability & Damage <br>
Jessie's Java is not responsible for any loss, theft, or damage to personal laptops or other belongings. Customers assume full responsibility for any damage to rented equipment and will be charged for repairs or replacement.
We are not liable for data loss, connectivity issues, or personal technical malfunctions.
<br><br>
Privacy & Security <br>
We may monitor public computer booths to ensure compliance with shop policies.
Customers must log out of any personal accounts before leaving to protect their data.
Wi-Fi access is provided as a courtesy, and we are not responsible for security risks or interruptions.
<br> <br>
Amendments & Updates: We reserve the right to modify this Agreement at any time. Continued use of our services after updates indicates acceptance of the revised terms.
<br>
            </small>
            <br>
        </div>
    </div>
<br><br> <br> <br>



        <button type="submit" class="submit">Reserve</button>

</div>



       </form>
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
            
                
</div>   
               <hr>
    <script src="script.js"></script>
</body>
</html>