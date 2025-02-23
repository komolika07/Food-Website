<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'db.php'; // Include DB connection

    // Sanitize input
    $user_id = intval($_POST['user_id']);
    $user_name =$_POST['user-name'];
    $phone = $_POST['phone'];
    $address_line = $_POST['address_line'];
    $city = $_POST['city'];
    $state = 'Maharashtra'; // Fixed state
    $zip = $_POST['zip'];
    $locality = $_POST['Locality'];
    $landmark = $_POST['landmark'];
    $alt_phone = $_POST['alt-phone'];

    // Check if the user_id exists in the parent table
    $checkUserQuery = "SELECT user_id FROM user_form WHERE user_id = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // User exists, insert address
        $stmt->close();

        $insertQuery = "INSERT INTO user_addresses (user_id, user_name,phone,address_line, city, state, zip_code, locality, landmark, alt_phone) VALUES (?, ?, ?, ?, ?, ? , ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("isssssssss", $user_id, $user_name, $phone, $address_line, $city, $state, $zip, $locality, $landmark, $alt_phone);

        if ($stmt->execute()) {
            // Store success message in session
            $_SESSION['alert'] = ['message' => 'Address added successfully.', 'type' => 'success'];
        } else {
            // Store error message in session
            $_SESSION['alert'] = ['message' => 'Failed to add address.', 'type' => 'error'];
        }
    } else {
        $_SESSION['alert'] = ['message' => 'Error: User ID does not exist.', 'type' => 'error'];
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the profile page
    // header("Location: ../View/profile.php");
    if (isset($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        // Default fallback if no referer is available (in case of direct access or other errors)
        header("Location: ../View/profile.php");
    }
    exit;
}
?>
