<?php
$pageTitle = "Menu";
$pageStyles = [
    "../assets/css/pages/cart.css?v=2.0", // Menu-specific styles
];
include '../includes/Layout/header.php';
// include '../includes/Layout/Loginform.php';
include '../includes/Layout/navbar.php';
?>

<?php
require_once '../includes/db.php';
include "../includes/auth.php";
$user_id = $_SESSION['user-id'];

$sql = "SELECT c.id AS cart_id, c.quantity, 
               p.name, p.image_path, p.price, p.discounted_price 
        FROM cart c 
        JOIN menu_items p ON c.product_id = p.id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);


$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['discounted_price'] * $item['quantity'];
}

// Define delivery charge (e.g., flat rate)
$delivery_charge = 20.00;

// Calculate total
$total = $subtotal + $delivery_charge;
$_SESSION['subtotal'] = $subtotal;
$_SESSION['delivery_charge'] = $delivery_charge;
$_SESSION['total_price'] = $total;
?>

<section class="Common-sec container">
    <!-- <h3>My <b>Cart</b></h3> -->
    <p><a href="HomePage.php"><i class="fa-solid fa-house"></i> Home</a> > Cart</p>
</section>

<div class="cart-container">
    <!-- Cart Table -->
    <div class="cart-table-container">
        <!-- <h1>Your Cart</h1> -->
        <?php if (!empty($cart_items)): ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item):
                        $total_price = $item['discounted_price'] * $item['quantity'];
                        ?>
                        <tr>
                            <td><img src="../admin/<?= htmlspecialchars($item['image_path']) ?>"
                                    alt="<?= htmlspecialchars($item['name']) ?>" width="80"></td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>₹<?= htmlspecialchars($item['discounted_price']) ?></td>
                            <td>
                                <div class="quantity-container">
                                    <form action="../includes/Layout/update_cart.php" method="POST" class="quantity-form">
                                        <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                        <button type="submit" name="decrement" class="decrement-btn">-</button>
                                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>">
                                        <button type="submit" name="increment" class="increment-btn">+</button>
                                    </form>
                                </div>
                            </td>
                            <td>₹<?= number_format($total_price, 2) ?></td>
                            <td>
                                <form action="../includes/Layout/remove_cart.php" method="POST">
                                    <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                    <button type="submit" class="remove-btn">&times;</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="No-cart-items">
                <img src="../assets/images/cart.png">
                <p>Your cart is empty</p>
                <a href="menu.php" class=" primary-btn">Go Shopping</a>
            <?php endif; ?>
        </div>
    </div>
    <!-- Cart Summary -->
    <div class="cart-summary">
        <h2>Cart Summary</h2>
        <div class="summary-item">
            <span>Subtotal:</span>
            <span>₹<?= number_format($subtotal, 2) ?></span>
        </div>
        <div class="summary-item">
            <span>Delivery:</span>
            <span>₹<?= number_format($delivery_charge, 2) ?></span>
        </div>
        <div class="summary-item" style="font-weight: bold;">
            <span>Total:</span>
            <span>₹<?= number_format($total, 2) ?></span>
        </div>
        <button class="checkout-btn primary-btn" onclick="checkoutPage(true)">Proceed to Checkout</button>
    </div>

</div>
<?php include '../includes/Layout/footer.php'; ?>