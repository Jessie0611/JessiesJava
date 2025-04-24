<?php
include("database.php");

$resID = $_GET['resID'] ?? null; //get resID
$res = null;

if ($resID) {//If a reservation ID was provided, Query DB for info. 
    $stmt = $conn->prepare("
        SELECT r.resID, u.fName, u.lName 
        FROM reservations r 
        JOIN users u ON r.userID = u.userID 
        WHERE r.resID = ?
    ");//Joins  reservations & users tables to get first and last name. Fetches the result into $res.
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
    <title>Jessie's Java</title>
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
<br>
<?php if ($res): ?>
        <h4>Reservation #<?= htmlspecialchars($resID) ?> for <?= $res['fName'] . " " . $res['lName'] ?> has been successfully canceled.</h4>
    <?php else: ?>
    <?php endif; ?>
<br> <br>
    <a href="search.php"><button>Back To Search</button></a>
    <br>
<br>
<?php include('footer.php'); ?>
    <script src="script.js"></script>
</div>
</body>
</html>
