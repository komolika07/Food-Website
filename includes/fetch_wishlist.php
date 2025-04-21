

<?php
session_start();
header('Content-Type: application/json');

require_once 'db.php'; 
include 'auth.php';

if (!isset($_SESSION['user-id'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in to view your wishlist.', 'data' => []]);
    exit;
}

$user_id = $_SESSION['user-id'];

$query = "
    SELECT w.product_id, w.type, 
           CASE 
               WHEN w.type = 'menu_item' THEN m.name
               ELSE d.deal_name 
           END AS name,
           CASE 
               WHEN w.type = 'menu_item' THEN m.image_path
               ELSE d.deal_image 
           END AS image_path,
           CASE 
               WHEN w.type = 'menu_item' THEN m.price
               ELSE w.totalOriginalPrice
           END AS price,
            CASE 
               WHEN w.type = 'menu_item' THEN m.status
               ELSE d.status
           END AS status,
           CASE 
               WHEN w.type = 'menu_item' THEN m.discounted_price
               ELSE d.deal_price 
           END AS discounted_price
    FROM wishlist w
    LEFT JOIN menu_items m ON w.product_id = m.id AND w.type = 'menu_item'
    LEFT JOIN deals d ON w.product_id = d.id AND w.type = 'deal'
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

echo json_encode(['success' => true, 'message' => 'Wishlist fetched successfully.', 'data' => $wishlistItems]);
?>
