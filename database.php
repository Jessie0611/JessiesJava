<?php
$host = "127.0.0.1";
$port = 3306;
$user = "root";
$password = "";
$dbname = "jessiesjava";

// Create a MySQLi connection
$conn = new mysqli($host, $user, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST['fName'], $_POST['lName'], $_POST['email'], $_POST['phone'], $_POST['resDate'], $_POST['resTime'], $_POST['resType'])
        && !empty($_POST['fName']) && !empty($_POST['email'])
    ) {
        $fName = trim($_POST['fName']);
        $lName = trim($_POST['lName']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $resDate = trim($_POST['resDate']);
        $resTime = trim($_POST['resTime']);
        $resType = (int)$_POST['resType']; 

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<p>Error: Invalid email format.</p>";
            $conn->close();
            exit();
        }

        $conn->begin_transaction();

        try {
            // Check if user already exists
            $stmt = $conn->prepare("SELECT userID FROM users WHERE eMail = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 0) {
                // Insert new user
                $stmt->close();
                $stmt = $conn->prepare("INSERT INTO users (fName, lName, eMail, phoneNum) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $fName, $lName, $email, $phone);
                $stmt->execute();
                $userID = $stmt->insert_id; // Get the newly inserted userID
                $stmt->close();
            } else {
                $stmt->bind_result($userID);
                $stmt->fetch();
                $stmt->close();
            }

            // Get reservation price
            $stmt = $conn->prepare("SELECT resPrice FROM restype WHERE resTypeID = ?");
            $stmt->bind_param("i", $resType);
            $stmt->execute();
            $stmt->bind_result($totalAmount);
            $stmt->fetch();
            $stmt->close();

            if (!$totalAmount) {
                throw new Exception("Invalid reservation type.");
            }

            // Insert reservation
            $status = "Pending";
            $stmt = $conn->prepare("INSERT INTO reservations (userID, resTypeID, resDate, resTime, totalAmount, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissds", $userID, $resType, $resDate, $resTime, $totalAmount, $status);
            $stmt->execute();
            $resID = $stmt->insert_id;
            $stmt->close();

            $conn->commit();

            // Redirect to confirmation page
            header("Location: /JessiesJava/confirmation.php?resID=" . urlencode($resID));
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        echo "<p>Error: All required fields must be filled.</p>";
    }

    $conn->close();
}
?>
