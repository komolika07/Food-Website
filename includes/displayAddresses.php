<?php
include "../includes/db.php";

$user_id = $_SESSION['user-id']; // Assuming you already have the user ID from session

// Fetch all addresses for the user
$sql = "SELECT * FROM user_addresses WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Loop through each address and display them
    while ($row = $result->fetch_assoc()) {
        echo "<div class='address'>";
        echo "<div class='flexx'>";
        echo "<p>" . htmlspecialchars($row['user_name']) . "</p>";
        echo "<p>" . htmlspecialchars($row['phone']) . "</p>";
        echo "</div>";
        // echo "<p>Address Line: " . htmlspecialchars($row['address_line']) . "</p>";
        // echo "<p>City: " . htmlspecialchars($row['city']) . "</p>";
        // echo "<p>State: " . htmlspecialchars($row['state']) . "</p>";
        // echo "<p>ZIP Code: " . htmlspecialchars($row['zip_code']) . "</p>";

        echo "<p>" . htmlspecialchars($row['locality']) . ", " . htmlspecialchars($row['address_line']) . ", " . htmlspecialchars($row['city']) . ", " . "</p>";
        echo "<p>" . htmlspecialchars(($row['state'])) . " - " . htmlspecialchars($row['zip_code']) . "</p>";
        echo "<div class='actions'>";
        echo "<button class='edit-address primary-btn'
        data-user-name='" . htmlspecialchars($row['user_name']) . "' 
        data-phone='" . htmlspecialchars($row['phone']) . "' 
        data-id='" . htmlspecialchars($row['address_id']) . "' 
        data-address-line='" . htmlspecialchars($row['address_line']) . "'
        data-city='" . htmlspecialchars($row['city']) . "'
        data-state='" . htmlspecialchars($row['state']) . "'
        data-zip='" . htmlspecialchars($row['zip_code']) . "'
        data-locality='" . htmlspecialchars($row['locality']) . "'
        data-landmark='" . htmlspecialchars($row['landmark']) . "'
        data-alt-phone='" . htmlspecialchars($row['alt_phone']) . "'>
        <i class='fa-solid fa-pen-to-square'></i></button>";
        echo "<button class='delete-address' data-id='" . htmlspecialchars($row['address_id']) . "'><i class='fa-solid fa-trash'></i></button>";
        echo "</div>";
        echo "</div>";

    }
} else {
    echo "<p>No addresses found. Please add your address.</p>";
}

$stmt->close();
$conn->close();
?>