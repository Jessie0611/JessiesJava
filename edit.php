<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("database.php");

$success = false;

//Get resID from GET or POST safely
$resID = null;
if (isset($_GET['resID'])) {
    $resID = intval($_GET['resID']);
} elseif (isset($_POST['resID'])) {
    $resID = intval($_POST['resID']);
} else {
    echo "Reservation ID missing.";
    exit;
}

function convertTo12Hour($time) {
    return date("g:i A", strtotime($time));
}

//Fetch reservation details (for display + form values)
$stmt = $conn->prepare("SELECT r.*, u.fName, u.lName, rt.typeName, rt.resPrice 
    FROM reservations r
    JOIN users u ON r.userID = u.userID
    JOIN restype rt ON r.resTypeID = rt.resTypeID
    WHERE r.resID = ?
");
$stmt->bind_param("i", $resID);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

if (!$res) {
    echo "Reservation not found.";
    exit;
}

//Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newDate = $_POST['resDate'];
    $startTime = $_POST['resStartTime'];
    $endTime = $_POST['resEndTime'];
    $newResTypeID = intval($_POST['resTypeID']);

    $currentDate = new DateTime();

    // Validate if selected time is in the past
    $selectedDateTime = new DateTime("$newDate $startTime");
    if ($selectedDateTime < $currentDate) {
        echo "<p class='error'>Selected time is in the past. Please choose a future date and time.</p>";
        exit;
    }

    // Set open and close times based on the day of the week
    $dayOfWeek = date('w', strtotime($newDate));
    switch ($dayOfWeek) {
        case 0: $openTime = "09:00"; $closeTime = "20:00"; break;
        case 1: case 2: case 3: case 4: $openTime = "06:00"; $closeTime = "21:00"; break;
        case 5: case 6: $openTime = "06:00"; $closeTime = "22:00"; break;
        default:
            echo "<p class='error'>Invalid day selected. Please choose a valid day.</p>";
            exit;
    }

    // Check if times are within allowed hours
    if ($startTime < $openTime || $endTime > $closeTime) {
        echo "<p class='error'>Reservation must be between " . convertTo12Hour($openTime) . " and " . convertTo12Hour($closeTime) . ".</p>";
        exit;
    }

    //Update reservation
    $update = $conn->prepare("UPDATE reservations 
        SET resDate = ?, resStartTime = ?, resEndTime = ?, resTypeID = ? 
        WHERE resID = ?
    ");
    $update->bind_param("sssii", $newDate, $startTime, $endTime, $newResTypeID, $resID);

    if ($update->execute()) {
        $success = true;
        header("Location: editConfirm.php?resID=$resID");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Reservation - Jessie's Java</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="content">
        <div class="hero">
            <img src="Images/JJ-resPaymentHero.png" alt="Hero Image" width="100%">
        </div>

        <?php include('nav.php'); ?>

        <h2>Edit Reservation for <?= htmlspecialchars($res['fName'] . " " . $res['lName']) ?></h2>

        <?php if ($success): ?>
            <p class="success">Edit Current Reservation</p>
        <?php endif; ?>

        <b><p>Please note: Payments will be processed within 24 hours prior to your reservation. Any adjustments to the cost will be reflected in your final bill.</p></b>

        <form action="edit.php" method="POST">
            <input type="hidden" name="resID" value="<?= $resID ?>">

            <label>Current Reservation Type: <strong><?= htmlspecialchars($res['typeName']) ?></strong></label><br><br>

            <label for="resTypeID">Select Your Space</label>
            <select id="resTypeID" name="resTypeID" required>
                <option value="1" <?= ($res['resTypeID'] == 1) ? 'selected' : '' ?>>($60.00/hr) BYOL Table</option>
                <option value="2" <?= ($res['resTypeID'] == 2) ? 'selected' : '' ?>>($100.00/hr) Computer Booth</option>
                <option value="3" <?= ($res['resTypeID'] == 3) ? 'selected' : '' ?>>($200.00/hr) Collaboration Room</option>
            </select><br>

            <label for="resDate">Date:</label>
            <input type="date" name="resDate" value="<?= htmlspecialchars($res['resDate']) ?>" required><br>

            <label for="resStartTime">Start Time:</label>
            <input type="time" name="resStartTime" value="<?= htmlspecialchars($res['resStartTime']) ?>" required><br>

            <label for="resEndTime">End Time:</label>
            <input type="time" name="resEndTime" value="<?= htmlspecialchars($res['resEndTime']) ?>" required><br>

            <button type="submit" class="button">Save Changes</button>
        </form>

        <p>- OR -</p>
        <a href="search.php"><button>Back to Search</button></a>

        <?php include('footer.php'); ?>
        <script src="script.js"></script>
    </div>
</body>
</html>
