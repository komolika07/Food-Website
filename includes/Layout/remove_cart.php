<?php
session_start();
require_once '../db.php'; // Adjust path as needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = $_POST['cart_id'];

    $sql = "DELETE FROM cart WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $cart_id);
    $stmt->execute();
}

header('Location: ../../view/cart.php');
exit;
