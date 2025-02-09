<?php
session_start();
require_once '../db.php';
include "../auth.php";
// if (!isset($_SESSION['user-id'])) {
//     header('Location: ../view/loginForm.php');
//     exit();
// }


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = $_POST['cart_id'];

    if (isset($_POST['increment'])) {
        $sql = "UPDATE cart SET quantity = quantity + 1 WHERE id = ?";
    } elseif (isset($_POST['decrement'])) {
        $sql = "UPDATE cart SET quantity = quantity - 1 WHERE id = ? AND quantity > 1"; // Prevent quantity from going below 1
    }

    if (isset($sql)) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $cart_id);
        $stmt->execute();
    }
}

header('Location: ../../view/cart.php');
exit;

?>
