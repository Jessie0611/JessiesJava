<?php
include("database.php");

$resID = $_GET['resID'] ?? null;
$res = null;

if ($resID) {
    $stmt = $conn->prepare("
        SELECT r.resID, u.fName, u.lName 
        FROM reservations r 
        JOIN users u ON r.userID = u.userID 
        WHERE r.resID = ?
    ");
    $stmt->bind_param("i", $resID);
    $stmt->execute();
    $result = $stmt->get_result();
    $res = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation Canceled</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="content">
    <div class="hero">
        <img src="Images/JJ-resPaymentHero.png" alt="Hero Image Unavailable" width="100%">
    </div>
    <?php include('nav.php'); ?>
<br>
<h2>Reservation Canceled</h2>
<br>
<?php if ($res): ?>
        <h4>Reservation #<?= htmlspecialchars($resID) ?> for <?= $res['fName'] . " " . $res['lName'] ?> has been successfully canceled.</h4>
    <?php else: ?>
    <?php endif; ?>
<br> <br>
    <a href="search.php"><button>Back To Search</button></a>
    <br>
    <?php include('footer.php'); ?>
</div>
</body>
</html>
