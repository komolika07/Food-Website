<?php
session_start();
header('Content-Type: application/json');

require_once 'db.php'; // Database connection file
include 'auth.php'; // Authentication check file

// Check if the user is logged in
if (!isset($_SESSION['user-id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Please log in to add items to your wishlist.',
    ]);
    exit;
}

$user_id = $_SESSION['user-id'];
$product_id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

// Validate product ID
if (!$product_id) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid product ID.',
    ]);
    exit;
}

// Check if the product is already in the wishlist
$check_query = "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param('ii', $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Product is already in the wishlist
    echo json_encode([
        'success' => false,
        'message' => 'Product is already in your wishlist.',
    ]);
} else {
    // Add the product to the wishlist
    $insert_query = "INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param('ii', $user_id, $product_id);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Product added to your wishlist.',
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to add product to wishlist. Please try again.',
        ]);
    }
}
?>
