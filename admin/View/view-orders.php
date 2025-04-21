<?php
include '../includes/db.php'; //included database connction file

?>

<!-- individual css file adding for particular page css -->
<?php
$pageTitle = "Menu";
$pageStyles = [
    "../Assets/css/page/view-orders.css?v=1.0", // Menu-specific styles
];
include '../includes/layout/header.php';
?>
<?php
$sql = "SELECT o.*, u.*, a.*
 FROM orders o
 JOIN user_form u ON o.user_id = u.user_id
 JOIN user_addresses a ON o.address_id = a.address_id";

$stmt = $conn->prepare($sql);
// $stmt->bind_param("ii", $user_id, $order_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

// Close Connection
$conn->close();
?>
<div class="main-content">
    <h1>View Orders</h1>
    <p><a href="dashboard.php"><i class="fa-solid fa-house"></i> Home</a> / Manage Orders / View Orders</p>

    <hr>

    <div class="container">
    <label for="orderStatusDropdown">Filter by Status:</label>
    <select id="orderStatusDropdown" onchange="showOrders()">
        <option value="All">All</option>
        <option value="Pending">Pending</option>
        <option value="Confirmed">Confirmed</option>
        <option value="Processing">Processing</option>
        <option value="Out For Delivery">Out For Delivery</option>
        <option value="Delivered">Delivered</option>
        <option value="Cancelled">Cancelled</option>
    </select>

    <!-- Order Sections -->
    <div id="ordersContainer">
        <div id="All" class="orders-container">All Orders</div>
        <div id="Pending" class="orders-container">Pending Orders</div>
        <div id="Confirmed" class="orders-container">Confirmed Orders</div>
        <div id="Processing" class="orders-container">Processing Orders</div>
        <div id="Out For Delivery" class="orders-container">Out For Delivery Orders</div>
        <div id="Delivered" class="orders-container">Delivered Orders</div>
        <div id="Cancelled" class="orders-container">Cancelled Orders</div>
    </div>
</div>

</div>


<!-- footer -->
<?php
include '../includes/layout/footer.php'
    ?>