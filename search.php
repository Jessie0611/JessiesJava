<?php
include("database.php");
//initialize var and array
$searchTerm = "";
$reservations = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") { //handle form submittion POST
    $searchTerm = trim($_POST["search"]); //Trims whitespace from user input.

    // Query user based on reservation ID (resID)
    $stmt = $conn->prepare("
    SELECT r.*, rt.typeName, u.fName, u.lName 
    FROM reservations r
    JOIN users u ON r.userID = u.userID
    JOIN restype rt ON r.resTypeID = rt.resTypeID
    WHERE r.resID = ?
    ");
//This query joins three tables: reservations (r) users (u) → to get user info restype (rt) → to get the type of reservation
    // Bind the search term (resID)
    $stmt->bind_param("i", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result(); //runs query, gets results

    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row; //Adds each result to the $reservations array.
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
    <div class="content">
        <div class="hero">
            <img src="Images/JJ-resPaymentHero.png" alt="Hero Image Unavailable" width="100%">
        </div>
        <?php include('nav.php'); ?>
<div class="searchRes">
        <h2>Find Your Reservation</h2>
        <p>Please enter your confirmation number:</p>
        <form method="post">
            <input type="number" name="search" placeholder="Enter confirmation number" required value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit" class="search">Search</button>
        </form>
<style>
    th, td{
        padding-left: 18px;
    }
    input{
        width: 200px;
        padding: 17px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 1px 1px 6px 1px  hsl(23, 7%, 23%);
        background-color: #ffffff;
}
</style>
<?php if (!empty($reservations)): ?>
        <h3>Reservation Results:</h3>
        <table>
            <tr>
               <th>Confirmation</th>
               <th>Name</th>
               <th>Type</th>
               <th>Date</th>
               <th>Start Time</th>
               <th>End Time</th>
               <th>Status</th>
               <th>Actions</th>
            </tr>
<?php foreach ($reservations as $res): ?>
        <tr>
            <td><?= $res['resID'] ?></td>
            <td><?= $res['fName'] . ' ' . $res['lName'] ?></td>
            <td><?= $res['typeName'] ?></td>
            <td><?= $res['resDate'] ?></td>
            <td><?= $res['resStartTime'] ?></td>
            <td><?= $res['resEndTime'] ?></td>

            <td><?= $res['status'] ?></td>
            <td>
        <form class="inline" action="edit.php" method="get">
        <input type="hidden" name="resID" value="<?= $res['resID'] ?>">
        <button type="submit" class="edit">Edit</button>
        </form>
<?php if ($res['status'] === 'Canceled'): ?>
        <em style="color: gray;">Already Canceled</em>
        <?php else: ?>
    <form class="inline" action="cancel.php" method="post" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
       <input type="hidden" name="resID" value="<?= $res['resID'] ?>">
       <button type="submit" class="cancel">Cancel</button>
    </form>
    <?php endif; ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <p>No reservations found for that confirmation number.</p>
        <?php endif; ?>
        <script src="script.js"></script>
        <br>
        </div>
        
  <br> <br> <br>
  <?php include('footer.php'); ?>
    </div>
    
</body>
</html>
