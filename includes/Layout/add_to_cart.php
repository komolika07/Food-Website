<?php
session_start();
header('Content-Type: application/json');

require_once '../db.php';
include '../auth.php';

// Check if the user is logged in
if (!isset($_SESSION['user-id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Please log in to add items to your cart.',
    ]);
    exit;
}

$user_id = $_SESSION['user-id'];
$product_id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1; // Default to 1 if not provided

// Validate product ID
if (!$product_id) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid product ID.',
    ]);
    exit;
}

// Validate quantity
if ($quantity <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Quantity must be greater than zero.',
    ]);
    exit;
}

// Check if the product is already in the cart
$check_query = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param('ii', $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update quantity if the product is already in the cart
    $update_query = "UPDATE cart SET quantity =  quantity + ? WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('iii', $quantity, $user_id, $product_id);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Quantity updated in your cart.',
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to update the cart. Please try again.',
        ]);
    }
} else {
    // Insert a new record for the product in the cart
    $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param('iii', $user_id, $product_id, $quantity);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Product added to your cart.',
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to add product to cart. Please try again.',
        ]);
    }
}
?>
