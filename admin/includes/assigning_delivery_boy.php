<?php
include 'db.php'; // Ensure the correct path

header('Content-Type: application/json'); // Set JSON response

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON input
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['order_id']) && isset($data['delivery_boy_id'])) {
        $order_id = $data['order_id'];
        $delivery_boy_id = $data['delivery_boy_id'];

        $sql = "UPDATE orders SET delivery_boy_id = ? WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $delivery_boy_id, $order_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Delivery boy assigned successfully!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to assign delivery boy."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request data."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

$conn->close();
?>
