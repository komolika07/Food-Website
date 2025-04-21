<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user-id'])) {
    echo "<p>Please log in to view your orders.</p>";
    exit;
}

$user_id = $_SESSION['user-id']; // Get the logged-in user ID

// Fetch all orders for the user
$sql = "SELECT order_id, created_at, total_price, payment_method, order_status FROM orders WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    echo "<table class='order-table'>";
    echo "<thead>";
    echo "<tr>
            <th>Order ID</th>
            <th>Date</th>
            <th>Status</th>
            <th>Total Price</th>
            <th>Action</th>
          </tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($order = $result->fetch_assoc()) {
        $statusClass = "";
        switch ($order['order_status']) {
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
        echo "<tr>";
        echo "<td> #" . htmlspecialchars($order['order_id']) . "</td>";
        echo "<td>" . htmlspecialchars(date('Y-m-d', strtotime($order['created_at']))) . "</td>";
        echo "<td > <p class='order-status  $statusClass '>" . htmlspecialchars($order['order_status']) . " </p> </td>";
        echo "<td>₹" . htmlspecialchars($order['total_price']) . "</td>";
        echo "<td><a href='order_summary.php?order_id=" . $order['order_id'] . "' class='view-details-btn'><i class='fa-solid fa-eye'></a></td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>No orders found.</p>";
}

$stmt->close();
$conn->close();
?>