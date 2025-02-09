<?php
session_start();
header('Content-Type: application/json');

require_once 'db.php'; // Database connection file
include 'auth.php'; // Authentication check file

// Check if the user is logged in
if (!isset($_SESSION['user-id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Please log in to manage your wishlist.',
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

// Remove the product from the wishlist
$delete_query = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($delete_query);
$stmt->bind_param('ii', $user_id, $product_id);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Product removed from your wishlist.',
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to remove product from wishlist. Please try again.',
    ]);
}
?>
