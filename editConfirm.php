<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("database.php");

// Check for resID
if (!isset($_GET['resID'])) {
    echo "Reservation ID missing.";
    exit;
}

$resID = intval($_GET['resID']);

// Fetch reservation details
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

// Calculate the total price (number of hours * price per hour)
$startTime = new DateTime($res['resStartTime']);
$endTime = new DateTime($res['resEndTime']);
$duration = $startTime->diff($endTime);
$totalHours = $duration->h + ($duration->i / 60);  // Calculate total hours (including minutes as fraction)

$totalPrice = $totalHours * $res['resPrice'];  // Total price
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
            <img src="Images/JJ-reserveHero.png" alt="Hero Image" width="100%">
        </div>

        <?php include('nav.php'); ?>

        <div class="editSuccess">
            <div class="success">
                <h2>Reservation Updated</h2>
                <h3>Your reservation has been successfully updated!</h3>
                <h3>Reservation Details</h3>
                <br>

                <b>Name:</b> &nbsp;<?= htmlspecialchars($res['fName'] . ' ' . $res['lName']) ?> <br><br>
                <b>Reservation Type:</b>  &nbsp; <?= htmlspecialchars($res['typeName']) ?> ($<?= number_format($res['resPrice'], 2) ?>/hr) <br><br>
                <b>Date:</b>  &nbsp; <?= htmlspecialchars($res['resDate']) ?> <br><br>
                <b>Time:</b>  &nbsp; <?= date("g:i A", strtotime($res['resStartTime'])) ?> - <?= date("g:i A", strtotime($res['resEndTime'])) ?> <br>
                <p><b>Price:</b> $<?= number_format($totalPrice, 2); ?></p>
                <b><p>Please note: Any adjustments to the cost will be reflected on your final bill.</p></b>
                <br><br>
            </div>
        </div>

        <a href="search.php"><button>Back to Search</button></a>
        <br>

        <?php include('footer.php'); ?>

    </div>
</body>
</html>
