<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = intval($_POST['booking_id']);
    $status = $_POST['status'];
    $table_number = intval($_POST['table_number']);

    $updateQuery = "UPDATE table_bookings SET status = ?, table_number = ? WHERE booking_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sii", $status, $table_number, $booking_id);

    if ($stmt->execute()) {
        $_SESSION['alert'] = ['message' => 'Booking updated successfully.', 'type' => 'success'];
    } else {
        $_SESSION['alert'] = ['message' => 'Failed to update booking.', 'type' => 'error'];
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the admin page
    header("Location: ../view/view_table_bookings.php");
    exit;
}
?>
