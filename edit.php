<?php
include("database.php");

if (!isset($_GET['resID'])) {
    echo "Reservation ID missing.";
    exit;
}

$resID = $_GET['resID'];
$success = false;

// Function to convert 24-hour time to 12-hour format
function convertTo12Hour($time) {
    return date("g:i A", strtotime($time));
}

// Business hours
$openTime = "09:00:00";
$closeTime = "21:00:00";

// Get reservation info
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
    $newTime = $_POST['resTime'];

    // Check business hours
    if ($newTime < $openTime || $newTime > $closeTime) {
        echo "<script>
        alert('Reservations are only allowed from " . convertTo12Hour($openTime) . " to " . convertTo12Hour($closeTime) . ".');
        window.location.href = 'edit.php?resID=" . $resID . "';
      </script>";
    exit;
    }

    $update = $conn->prepare("UPDATE reservations SET resDate = ?, resTime = ? WHERE resID = ?");
    $update->bind_param("ssi", $newDate, $newTime, $resID);
    if ($update->execute()) {
        $success = true;
        $res['resDate'] = $newDate;
        $res['resTime'] = $newTime;
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
    <title>Search Reservation - Jessie's Java</title>
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
    <label for="resDate">Date:</label><br>
    <input type="date" name="resDate" value="<?= $res['resDate'] ?>" required><br>

    <label for="resTime">Time:</label><br>
    <input type="time" name="resTime" value="<?= $res['resTime'] ?>" required><br>

    <button type="submit">Save Changes</button>
</form>

<br><br>
<a href="search.php"><button>Back to Search</button></a>
<br> <br>
  <?php include('footer.php'); ?>
    </div>
</body>
</html>
