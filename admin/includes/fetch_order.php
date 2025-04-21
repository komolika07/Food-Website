<?php
include 'db.php'; // Include database connection

$status = $_GET['status'];
$today = date('Y-m-d'); // Get today's date

// Fetch today's orders based on selected status
if ($status == "All") {
    $sql = "SELECT o.*, u.*, a.*
            FROM orders o
            JOIN user_form u ON o.user_id = u.user_id
            JOIN user_addresses a ON o.address_id = a.address_id
            WHERE DATE(o.created_at) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $today);
} else {
    $sql = "SELECT o.*, u.*, a.*
            FROM orders o
            JOIN user_form u ON o.user_id = u.user_id
            JOIN user_addresses a ON o.address_id = a.address_id
            WHERE o.order_status = ? AND DATE(o.created_at) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $status, $today);
}
$stmt->execute();
$result = $stmt->get_result();



$delivery_boy_sql = "SELECT * FROM delivery_boys WHERE status = 'active'";
$delivery_boy_result = $conn->query($delivery_boy_sql);



if ($result->num_rows > 0) {
    echo "<div class='order-table'>";
    while ($row = $result->fetch_assoc()) {
        $order_id = $row['order_id'];
        // Get status class based on order status
        // Get status class based on order status
        $statusClass = "";
        switch ($row['order_status']) { // Remove strtolower()
            case 'Pending':
            case 'Processing':
            case 'Out For Delivery':
                $statusClass = "status-yellow";
                break;
            case 'Confirmed':
            case 'Delivered':
                $statusClass = "status-green";
                break;
            case 'Cancelled':
                $statusClass = "status-red";
                break;
            default:
                $statusClass = "";
        }


        echo "<div class='order-row'>";
        echo "<div class='order-summary'>";
        echo "<strong>Order #" . $row['order_id'] . "</strong>";
        echo "<span class='customer-name'>" . $row['f_name'] . " " . $row['l_name'] . "</span>";
        echo "<span class='price'>$" . number_format($row['total_price'], 2) . "</span>";


        // Order status in row
        echo "<select class='status-dropdown' onchange='updateStatus($order_id, this.value)'>";
        $statuses = ['Pending', 'Processing', 'Out For Delivery', 'Delivered', 'Cancelled'];
        foreach ($statuses as $s) {
            $selected = ($row['order_status'] == $s) ? "selected" : "";
            echo "<option value='$s' $selected>" . ucfirst($s) . "</option>";
        }
        echo "</select>";

        // Delivery Boy Dropdown
        echo "<select class='delivery-dropdown' onchange='assignDeliveryBoy($order_id, this.value)'>";
        echo "<option value=''>Assign Delivery Boy</option>";
        while ($delivery_boy = $delivery_boy_result->fetch_assoc()) {
            $selected = ($row['delivery_boy_id'] == $delivery_boy['id']) ? "selected" : "";
            echo "<option value='" . $delivery_boy['id'] . "' $selected>" . htmlspecialchars($delivery_boy['name']) . "</option>";
        }
        echo "</select>";


        echo "<button class='toggle-button' onclick='toggleDetails(this)'><i class='fa-solid fa-eye'></i></button>";

        echo "</div>";
        
        // Hidden order details (opens on click)
        echo "<div class='order-details'>";

        // Left and Right Columns
        echo "<div class='order-content'>";

        // Left Column: Order Details
        echo "<div class='order-left'>";
        echo "<h4>Order Menu</h4>";

        // Fetch menu items
        $order_id = $row['order_id'];
        $menu_sql = "SELECT menu_items.*, order_items.quantity 
                     FROM order_items
                     JOIN menu_items ON order_items.product_id = menu_items.id
                     WHERE order_items.order_id = ?";
        $menu_stmt = $conn->prepare($menu_sql);
        $menu_stmt->bind_param("i", $order_id);
        $menu_stmt->execute();
        $menu_result = $menu_stmt->get_result();

        if ($menu_result->num_rows > 0) {
            echo "<div class='order-menu'>";
            while ($menu = $menu_result->fetch_assoc()) {
                echo "<div class='menu-item'>";
                echo "<img src='../" . htmlspecialchars($menu['image_path']) . "' alt='" . htmlspecialchars($menu['name']) . "' class='menu-img'>";
                echo "<div class='menu-details'>";
                echo "<span class='menu-name'>" . htmlspecialchars($menu['name']) . "</span>";
                echo "<span class='menu-quantity'>x" . intval($menu['quantity']) . "</span>";
                echo "</div>";
                echo "<span class='menu-price'>+$" . number_format($menu['discounted_price'], 2) . "</span>";
                echo "</div>";
            }
            echo "</div>"; // Close order-menu
        } else {
            echo "<p>No items found for this order.</p>";
        }

        // Show order status inside details
        echo "<p><strong>Order Status:</strong> <span class='status $statusClass'>" . ucfirst($row['order_status']) . "</span></p>";
        echo "<p><strong>Payment Status:</strong> " . ucfirst($row['payment_status']) . "</p>";
        echo "<p><strong>Total Price:</strong> <span class='total-price'>$" . number_format($row['total_price'], 2) . "</span></p>";
        echo "</div>"; // Close order-left

        // Right Column: Delivery Address
        echo "<div class='order-right'>";
        echo "<h4>Delivery Address</h4>";
        echo "<p><strong>Name:</strong> " . htmlspecialchars($row['user_name']) . "</p>";
        echo "<p><strong>Address:</strong> " . htmlspecialchars($row['address_line']) . "</p>";
        echo "<p><strong>City:</strong> " . htmlspecialchars($row['city']) . " - " . htmlspecialchars($row['zip_code']) . "</p>";
        echo "<p><strong>State:</strong> " . htmlspecialchars($row['state']) . ", India</p>";
        echo "<p><strong>Phone:</strong> " . htmlspecialchars($row['phone']) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
        echo "</div>"; // Close order-right

        echo "</div>"; // Close order-content
        echo "</div>"; // Close order-details

        echo "</div>"; // Close order-row
    }
    echo "</div>"; // Close order-table
} else {
    echo "<p>No orders found for today.</p>";
}

$stmt->close();
$conn->close();
?>