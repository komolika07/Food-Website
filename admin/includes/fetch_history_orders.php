<?php
include 'db.php'; // Include database connection

$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'); // Get selected date or default to today
$status = isset($_GET['status']) ? $_GET['status'] : 'All';


// Base SQL query
$sql = "SELECT o.*, u.*, a.*, d.name
        FROM orders o
        JOIN user_form u ON o.user_id = u.user_id
        JOIN user_addresses a ON o.address_id = a.address_id
        LEFT JOIN delivery_boys d ON o.delivery_boy_id = d.id
        WHERE DATE(o.created_at) = ?"; // Ensure filtering by date

// Add status filtering if not "All"
if ($status !== "All") {
    $sql .= " AND o.order_status = ?";
}

$stmt = $conn->prepare($sql);

// Bind parameters
if ($status === "All") {
    $stmt->bind_param("s", $date);
} else {
    $stmt->bind_param("ss", $date, $status);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<div class='order-table'>";
    while ($row = $result->fetch_assoc()) {
        $order_id = $row['order_id'];

        // Status Color Logic
        $statusClass = "";
        switch ($row['order_status']) {
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
        }

        echo "<div class='order-row'>";
        echo "<div class='order-summary'>";
        echo "<strong>Order #" . $row['order_id'] . "</strong>";
        echo "<span class='customer-name'>" . $row['f_name'] . " " . $row['l_name'] . "</span>";
        echo "<span class='price'>$" . number_format($row['total_price'], 2) . "</span>";
        echo "<span class='status $statusClass'>". $row['order_status']."</span>";
        echo "<button class='toggle-button' onclick='toggleDetails(this)'><i class='fa-solid fa-eye'></i></button>";
        echo "</div>";

        // Order Details
        echo "<div class='order-details'>";
        echo "<div class='order-content'>";

        // Order Items
        echo "<div class='order-left'>";
        echo "<h4>Order Menu</h4>";

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
            echo "</div>";
        } else {
            echo "<p>No items found for this order.</p>";
        }

        echo "<p><strong>Order Status:</strong> <span class='status $statusClass'>" . ucfirst($row['order_status']) . "</span></p>";
        echo "<p><strong>Payment Status:</strong> " . ucfirst($row['payment_status']) . "</p>";
        echo "<p><strong>Total Price:</strong> <span class='total-price'>$" . number_format($row['total_price'], 2) . "</span></p>";
        echo "<p><strong>Delivered By: </strong>" . (!empty($row['name']) ? $row['name'] : "Not Assigned") . "</p>";

        echo "</div>";

        // Delivery Address
        echo "<div class='order-right'>";
        echo "<h4>Delivery Address</h4>";
        echo "<p><strong>Name:</strong> " . htmlspecialchars($row['user_name']) . "</p>";
        echo "<p><strong>Address:</strong> " . htmlspecialchars($row['address_line']) . "</p>";
        echo "<p><strong>City:</strong> " . htmlspecialchars($row['city']) . " - " . htmlspecialchars($row['zip_code']) . "</p>";
        echo "<p><strong>State:</strong> " . htmlspecialchars($row['state']) . ", India</p>";
        echo "<p><strong>Phone:</strong> " . htmlspecialchars($row['phone']) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
        echo "</div>";

        echo "</div>"; // Close order-content
        echo "</div>"; // Close order-details
        echo "</div>"; // Close order-row
    }
    echo "</div>"; // Close order-table
} else {
    echo "<p>No orders found for the selected date.</p>";
}

$stmt->close();
$conn->close();
?>
