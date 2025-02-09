<?php
include "../includes/db.php";

// Check if the address ID is provided
if (isset($_GET['id'])) {
    $address_id = intval($_GET['id']); // Sanitize the input

    // Prepare SQL statement to delete the address
    $sql = "DELETE FROM user_addresses WHERE address_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $address_id);

    if ($stmt->execute()) {
        // Return success message in JSON format
        echo json_encode(['success' => true, 'message' => 'Address Deleted Successfully.']);
    } else {
        // Return failure message in JSON format
        echo json_encode(['success' => false, 'message' => 'Failed to delete address.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Missing address ID.']);
}
?>
