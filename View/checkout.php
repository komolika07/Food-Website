
<?php
$pageTitle = "Menu";
$pageStyles = [
    "../assets/css/pages/checkout.css?v=2.0", // Menu-specific styles
];
include '../includes/Layout/header.php';
// include '../includes/Layout/Loginform.php';
include '../includes/Layout/navbar.php';
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
// Include your database connection
include '../includes/db.php';
include '../includes/auth.php';

// Get user ID from session
$user_id = $_SESSION['user-id'];

// Fetch user details
$user_query = $conn->prepare("SELECT * FROM user_form WHERE user_id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();

// Fetch up to 3 addresses for the user
$address_query = $conn->prepare("SELECT * FROM user_addresses WHERE user_id = ?");
$address_query->bind_param("i", $user_id);
$address_query->execute();
$addresses = $address_query->get_result();
?>

<?php
// managing address

$sql = "SELECT COUNT(*) as address_count FROM user_addresses WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($address_count);
$stmt->fetch();
$stmt->close();

if ($address_count >= 3) {
    // You can display a message or disable the Add Address button
    $max_addresses_reached = true;
} else {
    $max_addresses_reached = false;
}

?>

<?php
if (isset($_SESSION['alert'])):
    $message = $_SESSION['alert']['message'];
    $type = $_SESSION['alert']['type'];
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            showAlert("<?php echo htmlspecialchars($message); ?>", "<?php echo $type; ?>");
        });
    </script>
    <?php
    unset($_SESSION['alert']); // Clear the alert message after showing it
endif;
?>
<?php
$order = isset($_SESSION['buy_now_order']) ? $_SESSION['buy_now_order'] : null;

?>


<?php

// Check if "Buy Now" is used; otherwise, load cart items
if (isset($_GET['isCart']) && $_GET['isCart'] == 'false' && isset($_GET['product_id']) && isset($_GET['quantity'])) {
    $product_id = intval($_GET['product_id']);
    $quantity = intval($_GET['quantity']);
    $isCart=$_GET['isCart'];
    $query = "SELECT * FROM menu_items WHERE id = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order_items = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Assign the requested quantity to the fetched product
    if (!empty($order_items)) {
        $order_items[0]['quantity'] = $quantity; // Set the quantity for "Buy Now"
    }
    foreach ($order_items as $item) {
        $subtotal = $item['discounted_price'] * $item['quantity'];
        $delivery_charge = 20;
        $total_price = $subtotal + $delivery_charge;
    }


} else {
    // Fetch cart items only if Buy Now is NOT used
    $query = "SELECT c.*, p.* FROM cart c JOIN menu_items p ON c.product_id = p.id WHERE c.user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order_items = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $total_price = isset($_SESSION['total_price']) ? $_SESSION['total_price'] : 0;
    $subtotal = isset($_SESSION['subtotal']) ? $_SESSION['subtotal'] : 0;
    $delivery_charge = isset($_SESSION['delivery_charge']) ? $_SESSION['delivery_charge'] : 0;
}


// Ensure Buy Now does not mix with cart items
if (isset($_GET['buy_now'])) {
    unset($_SESSION['buy_now_order']); // Reset Buy Now session to prevent mix-ups
}

?>

<input type="hidden" id="isCart" value="<?php echo htmlspecialchars($isCart)?>">
<input type="hidden" id="total-price" value="<?php echo htmlspecialchars($total_price); ?>">
<input type="hidden" id="quantity" value="<?php echo htmlspecialchars($quantity)?>">
<input type="hidden" id="product_id" value="<?php echo htmlspecialchars($product_id); ?>">


<!-- Alert msg  -->
<div id="custom-alert" class="alert-msg hidden">

</div>

<!-- common section  -->
<section class="Common-sec container">
    <!-- <h3>Contact <b>Us</b></h3> -->
    <p><a href="HomePage.php"><i class="fa-solid fa-house"></i> Home</a> > Checkout </p>
</section>


<section class="checkout">
    <div class="checkout-container">
        <div class="left-section">
            <div class="section open" id="login-section">
                <h3>
                    1. LOGIN
                    <p id="toggle-item-remove">
                        <span id="user-name-phone">
                            <?= $user['f_name'] . " " . $user['l_name'] . "   +" . $user['phone_number'] ?>
                            <button class="change-btn secondary-btn toggle-icon" id="change-btn">Change</button>
                        </span>

                    </p>
                </h3>
                <div class="section-content" id="login-details" style="display:none">
                    <p>Name: <?= $user['f_name'] . " " . $user['l_name'] ?> </p>
                    <p>Phone: <?= $user['phone_number'] ?> </p>
                    <p>Email: <?= $user['email'] ?> </p>
                    <a href="">Logout and sign in to another account</a><br>
                    <button class="btn-primary primary-btn" id="continue-checkout-btn">Continue checkout</button>
                    <p class="note">Please note that upon clicking "Logout" you will be redirected to the login page</p>
                </div>

                <!-- Section content that will show when the user clicks "change" -->

            </div>

            <div class="section">
                <h3>
                    2. DELIVERY ADDRESS
                </h3>

                <!-- Display Default Address First (without radio button initially) -->
                <?php
                $query = "SELECT * FROM user_addresses WHERE user_id = ? AND is_default = 1 LIMIT 1";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_SESSION['user-id']);  // Assuming the user ID is stored in the session
                $stmt->execute();
                $result = $stmt->get_result();

                // Fetch the default address (if it exists)
                if ($result->num_rows > 0) {
                    $default_address = $result->fetch_assoc();
                } else {
                    $default_address = null;
                }
                
                // ✅ Safely access address_id
                $default_address_id = $default_address ? $default_address['address_id'] : '';
                
                
                $stmt->close();
                ?>
                <input type="hidden" id="default-address-id" value="<?php echo htmlspecialchars($default_address_id); ?>">

                <div class="default-address" id="default-address-display">
                    <?php if ($default_address): ?>
                        <strong><?php echo htmlspecialchars($default_address['user_name']); ?></strong>
                        (<?php echo htmlspecialchars($default_address['phone']); ?>)
                        <p><?php echo htmlspecialchars("{$default_address['locality']}, {$default_address['address_line']}, {$default_address['city']}, {$default_address['state']} - {$default_address['zip_code']}"); ?>
                        </p>
                    <?php else: ?>
                        <p class="no-address">No default address selected</p>
                    <?php endif; ?>

                    <!-- Change Button Always Visible -->
                    <button type="button" class="change-address-btn secondary-btn"
                        id="change-address-btn">Change</button>
                </div>
                <div class="section-content" id="address-list-section" style="display: none;">
                    <!-- List of All Addresses with Radio Buttons -->
                    <?php while ($address = $addresses->fetch_assoc()): ?>
                        <div class="address">
                            <input type="radio" name="address" id="address-<?php echo $address['address_id']; ?>"
                                data-address-id="<?php echo $address['address_id']; ?>">
                            <strong><?php echo htmlspecialchars($address['user_name']); ?></strong>
                            (<?php echo htmlspecialchars($address['phone']); ?>)
                            <p><?php echo htmlspecialchars($address['locality'] . ', ' . $address['address_line'] . ', ' . $address['city'] . ', ' . $address['state'] . ' - ' . $address['zip_code']); ?>
                            </p>
                            <button class="primary-btn deliver-here-btn"
                                data-address-id="<?php echo $address['address_id']; ?>" style="display:none;">Deliver
                                Here</button>
                        </div>
                    <?php endwhile; ?>
                    <div id="address-list">

                        <!-- Address forms will appear here -->
                    </div>
                    <?php if (!$max_addresses_reached): ?>
                        <button type="button" id="add-address-btn" class="secondary-btn"
                            data-user-id="<?php echo $_SESSION['user-id']; ?>"><i class="fa-solid fa-plus"></i> Add
                            Address</button>

                    <?php else: ?>
                        <p>You can only add up to 3 addresses.</p>
                    <?php endif; ?>
                </div>

                <!-- Add Address Button -->

            </div>


            <div class="sectionn">
                <h3>3. ORDER SUMMARY</h3>
                <div class="sectionn-content">
                    <div class="order-summary">
                        <?php foreach ($order_items as $item): ?>
                            <div class="order-summary-inner">
                                <div class="order-summary-left">
                                    <div class="main-image">
                                        <img id="popup-main-image"
                                            src="../admin/<?php echo htmlspecialchars($item['image_path']); ?>"
                                            alt="Product Image">
                                        <div class="quantity-add">
                                            <!-- <div class="quantity-selector">
                                                <button class="decrement-btn">-</button>
                                                <input type="number"
                                                    value="" min="1"
                                                    class="quantity-input" name="quantity">
                                                <button class="increment-btn">+</button>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="order-summary-right">
                                    <h2 id="order-summary-category"><?php echo htmlspecialchars($item['category']); ?></h2>
                                    <h4 id="order-summary-title" style="font-size:1.2rem;">
                                        <?php echo htmlspecialchars($item['quantity']); ?> X
                                        <?php echo htmlspecialchars($item['name']); ?> <span class="rating">( ⭐
                                            <?php echo htmlspecialchars($item['rating']); ?>.0 )</span>

                                    </h4>

                                    <div class="price">
                                        <span id="order-summary-price">
                                            ₹<?php echo htmlspecialchars($item['discounted_price']); ?>
                                        </span>
                                        <?php if ($item['discount'] > 0) { ?>
                                            <span id="order-summary-original-price">
                                                ₹<?php echo htmlspecialchars($item['price']); ?>
                                            </span>
                                            <span id="order-summary-discount">
                                                <?php echo htmlspecialchars($item['discount']); ?>%
                                            </span>
                                        <?php } ?>


                                    </div>

                                    <div class="action-buttons">
                                        <button class="Remove-btn" data-id="">REMOVE</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="sectionn">
                <h3>
                    4. PAYMENT OPTIONS
                    <!-- <i class="fas fa-chevron-down toggle-icon"></i> -->
                </h3>
                <div class="sectionn-content">
                    <div class="payment-option">
                        <input type="radio" name="payment" value="cod" id="cod" checked onclick="showContinue('cod')">
                        <label for="cod">💰 Cash on Delivery</label>
                    <button id="continue-cod" class="continue-btn primary-btn">Confirm Order</button>

                    </div>
                   

                    <!-- Other Payment Methods -->
                    <div class="payment-option">
                        <input type="radio" name="payment" value="upi" id="upi" onclick="showContinue('upi')">
                        <label for="upi">🟢 UPI</label>
                        <p>Pay by any UPI app</p>    
                    <button id="continue-upi" class="continue-btn primary-btn hidden">Continue</button>

                    </div>

                    <div class="payment-option">
                        <input type="radio" name="payment" value="wallet" id="wallet" onclick="showContinue('wallet')">
                        <label for="wallet">💳 Wallets</label>
                        <p>Use Paytm, PhonePe, etc.</p>
                    <button id="continue-wallet" class="continue-btn primary-btn hidden">Continue</button>

                    </div>

                    <div class="payment-option">
                        <input type="radio" name="payment" value="card" id="card" onclick="showContinue('card')">
                        <label for="card">💳 Credit / Debit / ATM Card</label>
                        <p>Add and secure cards as per RBI guidelines</p>
                    <button id="continue-card" class="continue-btn primary-btn hidden">Continue</button>

                    </div>

                    <div class="payment-option">
                        <input type="radio" name="payment" value="netbanking" id="netbanking"
                            onclick="showContinue('netbanking')">
                        <label for="netbanking">🏦 Net Banking</label>
                        <p>Use UPI or cards for a better experience</p>
                    <button id="continue-netbanking" class="continue-btn primary-btn hidden">Continue</button>

                    </div>

                    <div class="payment-option">
                        <input type="radio" name="payment" value="emi" id="emi" onclick="showContinue('emi')">
                        <label for="emi">📆 EMI (Easy Installments)</label>
                    <button id="continue-emi" class="continue-btn primary-btn hidden">Continue</button>

                    </div>

                </div>

            </div>

        </div>

        <div class="price-details">
            <h4>PRICE DETAILS</h4>
            <div class="price-row">
                <span>Price (2 items)</span>
                <span><?= number_format($subtotal, 2) ?></span>
            </div>
            <div class="price-row">
                <span>Delivery Charges</span>
                <span style="color: green;"><?= number_format($delivery_charge, 2) ?></span>
            </div>
            <hr>
            <div class="price-row" style="font-weight: bold;">
                <span>Total Payable</span>
                <span><?= number_format($total_price, 2) ?></span>
            </div>
            <!-- <button class="btn-primary primary-btn">Place Order</button> -->
        </div>
    </div>



</section>

<script>
    document.querySelectorAll('.sectionn h3').forEach(header => {
        header.addEventListener('click', () => {
            const section = header.parentElement;
            section.classList.toggle('open');
        });
    });
</script>

<?php include("../includes/Layout/footer.php"); ?>