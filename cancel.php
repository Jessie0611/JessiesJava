<?php
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['resID'])) {
    $resID = $_POST['resID'];

    $stmt = $conn->prepare("UPDATE reservations SET status = 'Cancelled' WHERE resID = ?");
    $stmt->bind_param("i", $resID);
    if ($stmt->execute()) {
        header("Location: search.php?cancelled=1");
        exit;
    } else {
        echo "Failed to cancel reservation.";
    }
} else {
    echo "Invalid request.";
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
    <title>Search Reservation - Jessie's Java</title>
</head>
<body>
<div class="content">
        <div class="hero">
            <img src="Images/JJ-resPaymentHero.png" alt="Hero Image Unavailable" width="100%">
        </div>
        <?php include('nav.php'); ?>
