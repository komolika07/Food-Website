<?php
if (isset($_GET['id'])) {
    require_once 'db.php';
// Adjust path to your database connection file

    $id = intval($_GET['id']); // Sanitize the ID
    $sql = "DELETE FROM feedback WHERE feedback_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo 'success'; // Send success response
        } else {
            echo 'error: failed to execute query';
        }
        $stmt->close();
    } else {
        echo 'error: failed to prepare statement';
    }

    $conn->close();
} else {
    echo 'error: id not received';
}
?>
