<?php
require_once 'db.php'; // Include database connection

header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata'); // Set your timezone

$query = "SELECT id, deal_name, deal_price,deal_image, deal_validity FROM deals WHERE deal_validity >= NOW()";
$result = $conn->query($query);

$deals = [];
while ($row = $result->fetch_assoc()) {
    $deals[] = $row;
}

echo json_encode(['success' => true, 'data' => $deals]);
?>
