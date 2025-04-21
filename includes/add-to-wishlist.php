
<?php
session_start();
header('Content-Type: application/json');

require_once 'db.php'; 
include 'auth.php';

if (!isset($_SESSION['user-id'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in to add items to your wishlist.']);
    exit;
}

$user_id = $_SESSION['user-id'];
$product_id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$type = isset($_POST['type']) ? $_POST['type'] : '';


if (!$product_id || !in_array($type, ['menu_item', 'deal'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid product details.']);
    exit;
}

// Check if item is already in wishlist
$check_query = "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ? AND type = ?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param('iis', $user_id, $product_id, $type);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Item already in wishlist.']);
} else {
    $insert_query = "INSERT INTO wishlist (user_id, product_id, type) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param('iis', $user_id, $product_id, $type);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Item added to wishlist.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add item to wishlist.']);
    }
}
?>
