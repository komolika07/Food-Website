<?php
session_start();
require_once 'db.php';
header('Content-Type: application/json');

$response = ['success' => false]; // Default response

if (!isset($_SESSION['user-id'])) {
    $response['message'] = 'User not logged in.';
    echo json_encode($response);
    exit;
}

$user_id = $_SESSION['user-id'];
$buy_now = isset($_POST['isCart']) && $_POST['isCart'] === "false";

// Validate Address
if (empty($_POST['address_id'])) {
    $response['message'] = 'Please select an address.';
    echo json_encode($response);
    exit;
}
$address_id = intval($_POST['address_id']);

// Validate Payment Method
if (empty($_POST['payment_method'])) {
    $response['message'] = 'Please select a payment method.';
    echo json_encode($response);
    exit;
}
$payment_method = $_POST['payment_method'];

$total_price = floatval($_POST['total_price']); // Ensure it's a valid float
$order_status = "Pending";
$cart_items = [];

if ($buy_now) {
    // Buy Now Order
    if (empty($_POST['product_id']) || empty($_POST['quantity'])) {
        $response['message'] = 'Invalid product details.';
        echo json_encode($response);
        exit;
    }

    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    // Fetch Product Details
    $stmt = $conn->prepare("SELECT id, discounted_price FROM menu_items WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $price = $row["discounted_price"] * $quantity;
        $cart_items[] = [
            'product_id' => $row['id'],
            'quantity' => $quantity,
            'price' => $price,
        ];
    } else {
        $response['message'] = 'Product not found.';
        echo json_encode($response);
        exit;
    }

    $stmt->close();
} else {
    // Cart Order
    $stmt = $conn->prepare("SELECT c.product_id, c.quantity, (m.discounted_price * c.quantity) AS total_price 
                            FROM cart c 
                            JOIN menu_items m ON c.product_id = m.id 
                            WHERE c.user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $cart_items[] = [
            'product_id' => $row['product_id'],
            'quantity' => $row['quantity'],
            'price' => $row['total_price'], // Corrected to discounted price * quantity
        ];
    }

    $stmt->close();

    if (empty($cart_items)) {
        $response['message'] = 'Cart is empty.';
        echo json_encode($response);
        exit;
    }
}

// Insert Order
$stmt = $conn->prepare("INSERT INTO orders (user_id, address_id, total_price, payment_method, order_status, payment_status) 
                        VALUES (?, ?, ?, ?, ?,'pending')");
$stmt->bind_param("iisss", $user_id, $address_id, $total_price, $payment_method, $order_status);

if ($stmt->execute()) {
    $order_id = $stmt->insert_id;

    // Insert Order Items
    foreach ($cart_items as $item) {
        $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) 
                                     VALUES (?, ?, ?, ?)");
        $stmt_item->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
        $stmt_item->execute();
        $stmt_item->close();
    }

    // Clear Cart if order was from the cart
    if (!$buy_now) {
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }

    $response['success'] = true;
    $response['message'] = ($payment_method === 'cod') ? 'Order placed successfully!' : 'Proceed to Razorpay payment';
    $response['order_id'] = $order_id;
} else {
    $response['message'] = 'Order placement failed.';
}

$stmt->close();
$conn->close();
echo json_encode($response);
?>
