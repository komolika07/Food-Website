<?php
session_start();
header('Content-Type: application/json');

require_once 'db.php'; // Database connection file
include 'auth.php'; // Authentication check file

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['user-id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Please log in to view your wishlist.',
        'data' => []
    ]);
    exit;
}

$user_id = $_SESSION['user-id'];

// Fetch wishlist items
$query = "
    SELECT w.product_id, p.name, p.rating, p.discounted_price, p.discount, p.price, p.image_path, p.status, p.description
    FROM wishlist w
    JOIN menu_items p ON w.product_id = p.id
    WHERE w.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$wishlistItems = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $wishlistItems[] = $row;
    }
}

echo json_encode([
    'success' => true,
    'message' => 'Wishlist fetched successfully.',
    'data' => $wishlistItems
]);
?>