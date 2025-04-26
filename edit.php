<?php
include("database.php");

if (!isset($_GET['resID'])) {
    echo "Reservation ID missing.";
    exit;
}

$resID = $_GET['resID'];
$success = false;

function convertTo12Hour($time) {
    return date("g:i A", strtotime($time));
}

// Get reservation info before POST
$stmt = $conn->prepare("
    SELECT r.*, u.fName, u.lName, rt.typeName 
    FROM reservations r
    JOIN users u ON r.userID = u.userID
    JOIN restype rt ON r.resTypeID = rt.resTypeID
    WHERE r.resID = ?
");
$stmt->bind_param("i", $resID);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newDate = $_POST['resDate'];
    $startTime = $_POST['resStartTime'];
    $endTime = $_POST['resEndTime'];
    $newResTypeID = $_POST['resTypeID'];

    // Determine business hours for the selected date
    $dayOfWeek = date('w', strtotime($newDate));
    switch ($dayOfWeek) {
        case 0: $openTime = "09:00"; $closeTime = "20:00"; break;
        case 1: case 2: case 3: case 4: $openTime = "06:00"; $closeTime = "21:00"; break;
        case 5: case 6: $openTime = "06:00"; $closeTime = "22:00"; break;
        default:
            echo "<script>alert('Invalid day selected.'); window.location.href = 'edit.php?resID=$resID';</script>";
            exit;
    }

    // Time validations

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
    // Update reservation
    $update = $conn->prepare("
        UPDATE reservations 
        SET resDate = ?, resStartTime = ?, resEndTime = ?, resTypeID = ? 
        WHERE resID = ?
    ");
    $update->bind_param("sssii", $newDate, $startTime, $endTime, $newResTypeID, $resID);
    if ($update->execute()) {
        $success = true;
        $res['resDate'] = $newDate;
        $res['resStartTime'] = $startTime;
        $res['resEndTime'] = $endTime;
        $res['resTypeID'] = $newResTypeID;
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
    
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Jessie's Java</title>
</head>
<body>
<div class="content">
        <div class="hero">
            <img src="Images/JJ-resPaymentHero.png" alt="Hero Image Unavailable" width="100%">
        </div>
        <?php include('nav.php'); ?>


<h2>Edit Reservation for <?= $res['fName'] . " " . $res['lName'] ?></h2>

<?php if ($success): ?>
    <p style="color: green;">Reservation updated successfully!</p>
<?php endif; ?>
<style>
input{
    width: 200px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 1px 1px 6px 1px  hsl(23, 7%, 23%);
    background-color: #ffffff;
}
</style>
<form method="post" action="edit.php?resID=<?= $resID ?>
">
    <label>Reservation Type: <strong><?= $res['typeName'] ?></strong></label><br>
    <label for="resTypeID">Select Your Space</label><br>
<select id="resTypeID" name="resTypeID" required>
    <option value="">-- Select Your Space --</option>
    <option value="1" <?= $res['resTypeID'] == 1 ? 'selected' : '' ?>>($60.00) BYOL Table</option>
    <option value="2" <?= $res['resTypeID'] == 2 ? 'selected' : '' ?>>($100.00) Computer Booth</option>
    <option value="3" <?= $res['resTypeID'] == 3 ? 'selected' : '' ?>>($200.00) Collaboration Room</option>
</select><br><br>

    <label for="resDate">Date:</label><br>
    <input type="date" name="resDate" value="<?= $res['resDate'] ?>" required><br>

    <label for="resTime">Time:</label><br>
    <input type="time" name="resTime" value="<?= $res['resTime'] ?>" required><br>
<label for="resEndTime">End Time:</label><br>
<input type="time" name="resEndTime" value="<?= $res['resEndTime'] ?>" required><br>

    <button type="submit">Save Changes</button>
</form>

<br><br>
<a href="search.php"><button>Back to Search</button></a>
<br> <br> <br>
<br>
<?php include('footer.php'); ?>
    <script src="script.js"></script>
    </div>
</body>
</html>
