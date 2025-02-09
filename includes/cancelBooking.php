
<?php
include "db.php";

// Check if the address ID is provided
if (isset($_GET['id'])) {
    $booking_id = intval($_GET['id']); // Sanitize the input

    // Prepare SQL statement to delete the address
    $sql = "DELETE FROM table_bookings WHERE booking_id = ? AND status = 'Pending'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);

    if ($stmt->execute()) {
        // Return success message in JSON format
        echo json_encode(['success' => true, 'message' => 'Booking Cancelled Successfully.']);
    } else {
        // Return failure message in JSON format
        echo json_encode(['success' => false, 'message' => 'Failed to cancel booking.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Missing Booking ID.']);
}
?>
