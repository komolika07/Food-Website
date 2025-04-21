<?php
header('Content-Type: application/json');
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data['order_id'], $data['status'])) {
    $order_id = intval($data['order_id']);
    $new_status = trim($data['status']);

    $sql = "UPDATE orders SET order_status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_status, $order_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Order status updated successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update order status."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>
