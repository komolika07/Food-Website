<!-- <?php
session_start();
require_once 'db.php'; // Include your database connection

// Check if product_id and price are passed
if (isset($_GET['product_id']) && isset($_GET['price']) && isset($_GET['quantity'])) {
    $product_id = intval($_GET['product_id']);
    $price = floatval($_GET['price']);
    $quantity = intval($_GET['quantity']);

    // Fetch product details from the database
    $stmt = $conn->prepare("SELECT id, name, image_path,discounted_price FROM menu_items WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        // Store order details in session
        $_SESSION['buy_now_order'] = [
            'product_id' => $product_id,
            'name' => $product['name'],
            'image' => $product['image'],
            'price' => $price,
            'quantity' => $quantity,
            'total' => $price * $quantity
        ];

        // Redirect to checkout page
        header("Location: ../view/checkout.php");
        exit();
    } else {
        echo "Invalid product!";
    }
} else {
    echo "Missing product details!";
}
?> -->
