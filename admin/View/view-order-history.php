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
    <div class="container">
        <h1>View Orders</h1>
        <p><a href="dashboard.php"><i class="fa-solid fa-house"></i> Home</a> / Manage Orders / View Order History</p>

        <hr>

        <div class="flexx">
            <!-- Date Picker -->

            <div class="order-date-selection">
                <label for="orderDate">Select Date:</label>
                <input type="date" id="orderDate" value="<?php echo date('Y-m-d'); ?>" onchange="fetchOrders()">
            </div>


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
        let selectedDate = document.getElementById("orderDate").value;
        let selectedStatus = document.getElementById("orderStatusDropdown").value;
        console.log(selectedDate);
        console.log(selectedStatus);
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "../includes/fetch_history_orders.php?date=" + selectedDate + "&status=" + selectedStatus, true);
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