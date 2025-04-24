<?php
include("database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['resID'])) { //checks that form submitted via POST
    $resID = $_POST['resID']; //resID included in data, only valid cancellation request go through

//Prepares a parameterized SQL query to prevent SQL injection, Updates  status column in reservations table to 'Canceled'
    $stmt = $conn->prepare("UPDATE reservations SET status = 'Canceled' WHERE resID = ?"); //
    $stmt->bind_param("i", $resID);
    $stmt->execute();

    // Redirect to confirmation page
    header("Location: cancelConfirm.php?resID=" . $resID); //redirects the user to cancelConfirm.php
    exit;
} else {
//If the page was accessed without a POST request or without a resID, it just shows an error message and exits.
    echo "Invalid request.";
    exit;
}
