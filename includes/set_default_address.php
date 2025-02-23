<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['address_id'])) {
    $address_id = intval($_POST['address_id']);
    $user_id = $_SESSION['user-id'];

    // Set all addresses to not default
    $updateAllAddresses = "UPDATE user_addresses SET is_default = 0 WHERE user_id = ?";
    $stmt = $conn->prepare($updateAllAddresses);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Set the selected address as default
    $updateDefaultAddress = "UPDATE user_addresses SET is_default = 1 WHERE address_id = ? AND user_id = ?";
    $stmt = $conn->prepare($updateDefaultAddress);
    $stmt->bind_param("ii", $address_id, $user_id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
    $conn->close();
}
