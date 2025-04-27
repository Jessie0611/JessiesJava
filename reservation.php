<?php 
session_start();
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $fName = filter_input(INPUT_POST, 'fName', FILTER_SANITIZE_SPECIAL_CHARS);
    $lName = filter_input(INPUT_POST, 'lName', FILTER_SANITIZE_SPECIAL_CHARS);
    $eMail = filter_input(INPUT_POST, 'eMail', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
    $resTypeID = filter_input(INPUT_POST, 'resTypeID', FILTER_SANITIZE_NUMBER_INT);
    $resDate = filter_input(INPUT_POST, 'resDate', FILTER_SANITIZE_SPECIAL_CHARS);
    $resStartTime = filter_input(INPUT_POST, 'resStartTime', FILTER_SANITIZE_SPECIAL_CHARS);
    $resEndTime = filter_input(INPUT_POST, 'resEndTime', FILTER_SANITIZE_SPECIAL_CHARS);

    // Validate required fields
    if (empty($fName) || empty($lName) || empty($eMail) || empty($phone) || empty($resDate) || empty($resStartTime)) {
        echo "<script>alert('Error: All fields are required.'); window.location.href = 'reservation.php';</script>";
        exit;
    }

    // Validate email
    if (!filter_var($eMail, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.'); window.location.href = 'reservation.php';</script>";
        exit;
    }

    // Validate times
    if ($resEndTime <= $resStartTime) {
        echo "<script>alert('End time must be after start time.'); window.location.href = 'reservation.php';</script>";
        exit;
    }

    // Prevent past reservations
    $currentDate = date("Y-m-d");
    $currentTime = date("H:i");
    $bufferTime = date("H:i", strtotime("+1 hour"));
    if ($resDate < $currentDate || ($resDate == $currentDate && $resStartTime < $bufferTime)) {
        echo "<script>alert('Selected date/time is in the past or too soon. Reservations must be made at least 1 hour in advance.'); window.location.href = 'reservation.php';</script>";
        exit;
    }

    // Set business hours based on day
    $dayOfWeek = date('w', strtotime($resDate));
    switch ($dayOfWeek) {
        case 0: $openTime = "09:00"; $closeTime = "20:00"; break;
        case 5:
        case 6: $openTime = "06:00"; $closeTime = "22:00"; break;
        default: $openTime = "06:00"; $closeTime = "21:00"; break;
    }

    if ($resStartTime < $openTime || $resStartTime > $closeTime) {
        echo "<script>alert('Reservations must be between " . date("g:i A", strtotime($openTime)) . " and " . date("g:i A", strtotime($closeTime)) . ".'); window.location.href = 'reservation.php';</script>";
        exit;
    }

    // Check availability
    $availabilityQuery = "SELECT COUNT(*) as count FROM reservations WHERE resTypeID = ? AND resDate = ? AND (resStartTime < ? AND resEndTime > ?)";
    $stmt = $conn->prepare($availabilityQuery);
    $stmt->bind_param("isss", $resTypeID, $resDate, $resEndTime, $resStartTime);
    $stmt->execute();
    $stmt->bind_result($currentCount);
    $stmt->fetch();
    $stmt->close();

    // Capacity limits
    $maxAllowed = [1 => 20, 2 => 10, 3 => 3];
    $max = isset($maxAllowed[$resTypeID]) ? $maxAllowed[$resTypeID] : 0;
    if ($currentCount >= $max) {
        echo "<script>alert('Sorry, that time slot is fully booked.'); window.location.href = 'reservation.php';</script>";
        exit;
    }

    // Check or insert user
    $checkUserQuery = "SELECT userID FROM users WHERE eMail = ? OR phone = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("ss", $eMail, $phone);
    $stmt->execute();
    $stmt->bind_result($userID);
    if ($stmt->fetch()) {
        // User found
    } else {
        // Insert new user
        $stmt->close();
        $insertUserQuery = "INSERT INTO users (fName, lName, eMail, phone) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertUserQuery);
        $stmt->bind_param("ssss", $fName, $lName, $eMail, $phone);
        $stmt->execute();
        $userID = $stmt->insert_id;
    }
    $stmt->close();

    // Insert reservation
    $insertReservationQuery = "INSERT INTO reservations (userID, resTypeID, resDate, resStartTime, resEndTime, status) VALUES (?, ?, ?, ?, ?, 'Pending')";
    $stmt2 = $conn->prepare($insertReservationQuery);
    $stmt2->bind_param("iisss", $userID, $resTypeID, $resDate, $resStartTime, $resEndTime);

    if ($stmt2->execute()) {
        $_SESSION['userID'] = $userID;
        $_SESSION['resID'] = $stmt2->insert_id;
        header("Location: checkout.php");
        exit();
    } else {
        echo "<script>alert('Error: Reservation could not be saved.'); window.location.href = 'reservation.php';</script>";
        exit;
    }

    $stmt2->close();
    $conn->close();
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
    <?php include('nav.php'); ?>

<h3>Reserve Your Space at Jessie's Java!</h3>
<p>Already made a reservation? <br> <a href="search.php"><button> Manage Reservation </button></a></p>
<div class="serviceOpt">
    <div class="resAlign"><h3>Service Options:</h3>
  <p> <b>💻BYOL [$60.00 an hour]</b> A bring-your-own-laptop  table equpied with the optional otional extra monitor, headphones, keyboard and mouse. 
 <br><br>
<b>🖥️ Computer Booth [$100.00 an hour]</b> Booths come fully equipped with a programming computer, extra monitor, headphones, keyboard, and mouse.
<br><br>
<b>👨‍👨‍👦‍👦Collaboration Room [$200.00 an hour] </b> Looking for a more relaxed setting for your collaboration projects, away from the office grind? 
Our collaboration rooms are designed to provide just that, with two computer booths and space for up to eight BYOL areas,
 it's the perfect space for creative work. <br><br>
 <br>
 <small>Reservations must be made at least one hour before closing.</small>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <label for="resTypeID">Select Your Space</label>
    <select id="resTypeID" name="resTypeID" required>
        <option value="">- - - Select Your Space - - -</option>
        <option value="1">($60.00/hr) BYOL Table</option>
        <option value="2">($100.00/hr) Computer Booth</option>
        <option value="3">($200.00/hr) Collaboration Room</option>
    </select> 
    <label for="resDate">Reservation Date:</label>

    <input type="date" id="resDate" name="resDate" required>

    <label for="resStartTime">Reservation Begin Time:</label>
    <input type="time" id="resStartTime" name="resStartTime" required>
    <label for="resEndTime">Reservation End Time:</label>
    <input type="time" id="resEndTime" name="resEndTime" required>
<br>
<label for="fName">Customer Information:</label>

    <input type="text" id="fName" name="fName" placeholder="First Name" required>

    <input type="text" id="lName" name="lName" placeholder="Last Name" required>

    <input type="email" class="form-control is-invalid" id="eMail" name="eMail" placeholder="E-mail Address" required>

    <input type="tel" id="phone" name="phone" placeholder="Phone Number">
<div class="container">
    <p>Please read the disclosure agreement and check the box to continue. <br> 
<small>This Disclosure Agreement is made between Jessie's Java and the customers regarding the use of our <br> computer booth tables, bring-your-own-laptop (BYOL) tables, and collaboration rooms,
     along with the rental of additional technology based on availability. <br> By using our services, you acknowledge and agree to the terms outlined in this Agreement.</small>

    </p>

    <label>        <input type="checkbox" id="agreeCheckbox" required>
        I have read the disclosure agreement
    </label>
</div>

    <div class="accordionHeader">Disclosure Agreement</div>
    <div class="accordionContent">
    <small>
    <u>Reservations & Walk-Ins</u> <br>
    *** PAYMENTS WILL NOT BE PROCESSED UNTIL WITHIN 24 HOURS OF YOUR RESERVATION *** <br>
    This is due to any edits or cancelations that may occur before your reservation date.
<br><br>
Customers may reserve a BYOL table, computer booth, or collaboration room in advance via our website, phone, or in person. Walk-ins are welcome, but availability is not guaranteed. All reservations require prepayment, which will be billed at the time of service.<br><br>

Reservations for BYOL tables and computer booths will be held for 20 minutes past the reservation start time. If the customer fails to arrive within this grace period, the reservation will be forfeited, and the space may be given to walk-in customers.<br><br>

Collaboration Rooms are in high demand; if a customer does not arrive within 20 minutes of the reserved time, the room may be released for other use.<br><br>

<u>Rental of Additional Tech Equipment</u> <br>
Customers may rent tech accessories (e.g., monitors, keyboards, mice, chargers, gaming controllers) depending on availability. All rentals are charged hourly and must be paid for at the time of checkout. High-value items may require a security deposit. Equipment must be returned in the same condition; damage or loss will incur additional fees.<br><br>

<u>Cancellation & No-Show Policy</u> <br>
If you need to cancel a reservation, please let us know at least 2 hours in advance for BYOL tables and computer booths, and 4 hours in advance for collaboration rooms. There is no charge for cancellations made within these timeframes.<br><br>

Customers who fail to cancel or show up within the hold period may forfeit their reserved time slot. No charges apply unless the customer uses the space.<br><br>

<u>Edit or Cancel Your Reservation</u> <br>
To edit or cancel your reservation, you must have your confirmation number. You can manage your reservation by clicking the "Manage Reservations" button on the reservations page. Only customers with a valid confirmation number will be able to search for and edit or cancel their reservation.<br><br>

<u>Customer Responsibilities</u> <br>
Customers must use all facilities and equipment responsibly. Unauthorized software downloads or modifications to shop-owned computer booths are prohibited. Please follow all shop rules, including food and drink restrictions near electronics. Disruptive behavior (e.g., excessive noise, misuse of equipment) may result in removal from the premises.<br><br>

<u>Liability & Damage</u> <br>
Jessie’s Java is not responsible for loss, theft, or damage to personal belongings, including laptops. Customers are fully responsible for any rented equipment and may be charged for repair or replacement costs if items are damaged or lost. We are not liable for data loss, connectivity issues, or technical malfunctions on customer-owned devices.<br><br>

<u>Privacy & Security</u> <br>
Public computer booths may be monitored to ensure policy compliance. Customers must log out of all personal accounts before leaving to protect their data. Wi-Fi access is provided as a courtesy; we are not responsible for security risks or service interruptions.<br><br>

<u>Discounts</u> <br>
Students receive a 10% discount on in-store snacks and drinks with a valid student ID. Please show your ID at the time of purchase.<br><br>

<u>Amendments & Updates</u> <br>
We reserve the right to modify this Agreement at any time. Continued use of our services after changes indicates acceptance of the revised terms.
    </small>
    <br>
    </div>
<br><br>
<button type="submit" class="submit">Go To Checkout</button>
</div>
</div>
       </form>
       <?php include('footer.php'); ?>
       <script src="script.js"></script>
     <br>
</div> 
</body>
</html>