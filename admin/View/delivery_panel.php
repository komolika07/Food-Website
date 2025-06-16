<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="../Assets/css/page/view-orders.css">
</head>

<?php
// Ensure the session contains the correct delivery boy ID
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'delivery_person') {
    header("Location: admin_login.php");
    exit;
}

$deliveryBoyId = $_SESSION['id']; // Delivery boy's ID from session

// Include your database connection
include '../includes/db.php';

// Query to fetch orders assigned to the delivery boy
$sql = "SELECT * FROM orders WHERE delivery_boy_id = ? AND order_status != 'Cancelled'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $deliveryBoyId);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are orders assigned
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Order ID: " . $row['order_id'] . " - Status: " . $row['order_status'] . "<br>";
    }
} else {
    echo "No orders assigned to you.";
}

$stmt->close();
$conn->close();
?>



<div class="main-content">
    <div class="container">
        <h1>View Orders</h1>
        <p><a href="dashboard.php"><i class="fa-solid fa-house"></i> Home</a> / Manage Orders / View Order History</p>

        <hr>

        <div class="flexx">

            <!-- Filter Dropdown -->
            <div class="order-status-selection">

                <label for="orderStatusDropdown">Filter by Status:</label>
                <select id="orderStatusDropdown" onchange="fetchOrders()">
                    <option value="All">All</option>
                    <option value="Pending">Pending</option>
                    <option value="Confirmed">Confirmed</option>
                    <option value="Processing">Processing</option>
                    <option value="Out For Delivery">Out For Delivery</option>
                    <option value="Delivered">Delivered</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>
        </div>
        <!-- Order Container -->
        <div id="ordersContainer">
            <p>Loading orders...</p> <!-- Default message before data loads -->
        </div>
    </div>


</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetchOrders(); // Load today's orders initially
    });

    function fetchOrders() {
        let selectedStatus = document.getElementById("orderStatusDropdown").value;

        let xhr = new XMLHttpRequest();
        xhr.open("GET", "../includes/fetch_delivery_orders.php?status=" + selectedStatus, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("ordersContainer").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }

</script>
<!-- footer -->
<?php
include '../includes/layout/footer.php'
    ?>