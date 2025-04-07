<?php
include("database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['resID'])) {
    $resID = $_POST['resID'];

    $stmt = $conn->prepare("UPDATE reservations SET status = 'Canceled' WHERE resID = ?");
    $stmt->bind_param("i", $resID);
    $stmt->execute();

    // Redirect to confirmation page
    header("Location: cancelConfirm.php?resID=" . $resID);
    exit;
} else {
    // fallback if accessed directly
    echo "Invalid request.";
    exit;
}
