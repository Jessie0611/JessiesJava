<?php 
session_start();
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {  //Ensures the code only runs if the form is submitted via POST (a secure way to send data).
    // Sanitize input, this protects against basic XSS and injection attacks.
    $fName = filter_input(INPUT_POST, 'fName', FILTER_SANITIZE_SPECIAL_CHARS);
    $lName = filter_input(INPUT_POST, 'lName', FILTER_SANITIZE_SPECIAL_CHARS);
    $eMail = filter_input(INPUT_POST, 'eMail', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
    $resTypeID = filter_input(INPUT_POST, 'resTypeID', FILTER_SANITIZE_NUMBER_INT);
    $resDate = filter_input(INPUT_POST, 'resDate', FILTER_SANITIZE_SPECIAL_CHARS);
    $resTime = filter_input(INPUT_POST, 'resTime', FILTER_SANITIZE_SPECIAL_CHARS);
    $resEndTime = filter_input(INPUT_POST, 'resEndTime', FILTER_SANITIZE_SPECIAL_CHARS);
    $resID = $conn->insert_id;

    // Validate end time is after start time
    if ($resEndTime <= $resTime) {
        echo "<script type='text/javascript'>
                alert('End time must be after start time.');
                window.location.href = 'reservation.php';
              </script>";
        exit;
    }

$availabilityQuery = "SELECT COUNT(*) as count FROM reservations WHERE resTypeID = ? AND resDate = ? AND ((resTime < ? AND resEndTime > ?))";
$stmt = $conn->prepare($availabilityQuery);
$stmt->bind_param("isss", $resTypeID, $resDate, $resEndTime, $resTime);
$stmt->execute();
$stmt->bind_result($currentCount);
$stmt->fetch();
$stmt->close();

// Max allowed per resource
$maxAllowed = [1 => 20, 2 => 10, 3 => 3];
if ($currentCount >= $maxAllowed[$resTypeID]) {
    echo "<script type='text/javascript'>
            alert('Sorry, that time slot is fully booked.');
            window.location.href = 'reservation.php';
          </script>";
    exit;
}

    if (empty($fName) || empty($lName) || empty($eMail) || empty($phone) || empty($resDate) || empty($resTime)) {
        echo "<script type='text/javascript'>
                alert('Error: All fields are required.');
                window.location.href = 'reservation.php'; // Redirect back to the form
              </script>";
        exit; //Ensures all form fields are filled in, if not, shows an alert and redirects back.
    }
// Function to convert 24-hour time to 12-hour format with AM/PM
function convertTo12Hour($time) {
    return date("g:i A", strtotime($time)); 
}//g	Hour in 12-hour format (1–12)	1 to 12 : i	Minutes with leading zero	00, 01, 59 // A	AM or PM in uppercase	AM, PM

// Define current date and time for validation
$currentDate = date("Y-m-d");
$currentTime = date("H:i");

// Check if the selected date is in the past, Rejects reservations in the past (either wrong date or earlier today).
if ($resDate < $currentDate) {
    echo "<script type='text/javascript'>
            alert('The selected date is in the past.');
            window.location.href = 'reservation.php';
          </script>";
    exit;
} elseif ($resDate == $currentDate && $resTime < $currentTime) {
    echo "<script type='text/javascript'>
            alert('The selected time is in the past.');
            window.location.href = 'reservation.php';
          </script>";
    exit;
}

// Get day of the week for the selected reservation date
$dayOfWeek = date('w', strtotime($resDate));
// Validate time based on business hours
switch ($dayOfWeek) {
    case 0: // Sunday
        $openTime = "09:00"; 
        $closeTime = "20:00";
        break;
    case 1: // Monday
    case 2: // Tuesday
    case 3: // Wednesday
    case 4: // Thursday
        $openTime = "06:00";
        $closeTime = "21:00";
        break;
    case 5: // Friday
    case 6: // Saturday
        $openTime = "06:00";
        $closeTime = "22:00";
        break;
    default:
        echo "<script type='text/javascript'>
                alert('Invalid day of the week.');
                window.location.href = 'reservation.php';
              </script>";
        exit;
}
// Ensures the reservation time falls within business hours.
if ($resTime < $openTime || $resTime > $closeTime) {
    echo "<script type='text/javascript'>
            alert('Reservations are only allowed from " . convertTo12Hour($openTime) . " to " . convertTo12Hour($closeTime) . " on this day.');
            window.location.href = 'reservation.php';
          </script>";
    exit;
}
    //Check if user exists based on email OR phone, if found use same userID for repeat customers/not found->insert info into users table
    $checkUserQuery = "SELECT userID FROM users WHERE eMail = ? OR phone = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("ss", $eMail, $phone);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // User exists, fetch userID
        $stmt->bind_result($userID);
        $stmt->fetch();
    } else {
        // User does not exist, insert new user
        $insertUserQuery = "INSERT INTO users (fName, lName, eMail, phone) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertUserQuery);
        $stmt->bind_param("ssss", $fName, $lName, $eMail, $phone);
        $stmt->execute();
        $userID = $stmt->insert_id; // Get new userID
    }
    
    $stmt->close();
    
    // Insert reservation into `reservations` table
    $insertReservationQuery = "INSERT INTO reservations (userID, resTypeID, resDate, resTime, resEndTime, status) 
    VALUES (?, ?, ?, ?, ?, 'pending')";
$stmt2 = $conn->prepare($insertReservationQuery);
$stmt2->bind_param("iisss", $userID, $resTypeID, $resDate, $resTime, $resEndTime);

    if ($stmt2->execute()) {
        $_SESSION['userID'] = $userID;
        header("Location: checkout.php");
        exit();
            } else {
        echo "<script type='text/javascript'>
                alert('Error: Reservation could not be saved.');
                window.location.href = 'reservation.php'; // Redirect back to the form
              </script>";
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
  <p> <b>💻BYOL [$60.00]</b> A bring-your-own-laptop  table equpied with the optional otional extra monitor, headphones, keyboard and mouse. 
 <br><br>
<b>🖥️ Computer Booth [$100.00]</b> Booths come fully equipped with a programming computer, extra monitor, headphones, keyboard, and mouse.
<br><br>
<b>👨‍👨‍👦‍👦Collaboration Room [$200.00] </b> Looking for a more relaxed setting for your collaboration projects, away from the office grind? 
Our collaboration rooms are designed to provide just that, with two computer booths and space for up to eight BYOL areas,
 it's the perfect space for creative work. <br><br>
 <br>
 <small>Reservations must be made at least one hour before closing.</small>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <label for="resTypeID">Select Your Space</label>
    <select id="resTypeID" name="resTypeID" required>
        <option value="">- - - Select Your Space - - -</option>
        <option value="1">($60.00) BYOL Table</option>
        <option value="2">($100.00) Computer Booth</option>
        <option value="3">($200.00) Collaboration Room</option>
    </select> 
    <label for="resDate">Reservation Date:</label>

    <input type="date" id="resDate" name="resDate" required>

    <label for="resTime">Reservation Begin Time:</label>
    <input type="time" id="resTime" name="resTime" required>
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
Customers may reserve a BYOL table, computer booth, or collaboration room in advance via our website, phone, or in person. Walk-ins are welcome, but availability is not guaranteed. All reservations are billed by the hour at the time of service—no prepayment is required.
<br><br>
Reservations for BYOL tables and computer booths will be held for 20 minutes past the reservation start time. If the customer fails to arrive within this grace period, the reservation will be forfeited, and the space may be given to walk-in customers.
<br><br>
Collaboration Rooms are in high demand; if a customer does not arrive within 20 minutes of the reserved time, the room may be released for other use.
<br><br>
<u>Rental of Additional Tech Equipment</u> <br>
Customers may rent tech accessories (e.g., monitors, keyboards, mice, chargers, gaming controllers) depending on availability. All rentals are charged hourly and must be paid for at the time of checkout. High-value items may require a security deposit. Equipment must be returned in the same condition; damage or loss will incur additional fees.
<br><br>
<u>Cancellation & No-Show Policy</u> <br>
If you need to cancel a reservation, please let us know at least 2 hours in advance for BYOL tables and computer booths, and 4 hours in advance for collaboration rooms. There is no charge for cancellations made within these timeframes.
<br><br>
Customers who fail to cancel or show up within the hold period may forfeit their reserved time slot. No charges apply unless the customer uses the space.
<br><br>
<u>Customer Responsibilities</u> <br>
Customers must use all facilities and equipment responsibly. Unauthorized software downloads or modifications to shop-owned computer booths are prohibited. Please follow all shop rules, including food and drink restrictions near electronics. Disruptive behavior (e.g., excessive noise, misuse of equipment) may result in removal from the premises.
<br><br>
<u>Liability & Damage</u> <br>
Jessie’s Java is not responsible for loss, theft, or damage to personal belongings, including laptops. Customers are fully responsible for any rented equipment and may be charged for repair or replacement costs if items are damaged or lost. We are not liable for data loss, connectivity issues, or technical malfunctions on customer-owned devices.
<br><br>
<u>Privacy & Security</u> <br>
Public computer booths may be monitored to ensure policy compliance. Customers must log out of all personal accounts before leaving to protect their data. Wi-Fi access is provided as a courtesy; we are not responsible for security risks or service interruptions.
<br><br>
<u>Discounts</u> <br>
Students receive a 10% discount on in-store snacks and drinks with a valid student ID. Please show your ID at the time of purchase.
<br><br>
<u>Amendments & Updates</u> <br>
We reserve the right to modify this Agreement at any time. Continued use of our services after changes indicates acceptance of the revised terms.
    <br>
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