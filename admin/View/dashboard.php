
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<?php
$pageTitle = "Menu";
$pageStyles = [
    "../Assets/css/page/dashboard.css?v=1.0", // Menu-specific styles
];
include '../includes/layout/header.php';
?>
<?php
// Your DB connection
include '../includes/db.php';
$today = date('Y-m-d');
// Query to count users
$sql = "SELECT COUNT(*) AS total_users FROM user_form";
$sql2 = "SELECT COUNT(*) AS total_menu FROM menu_items";
$sql3 = "SELECT COUNT(*) AS today_orders FROM orders WHERE DATE(created_at) = '$today'";
$result = $conn->query($sql);
$result2 = $conn ->query($sql2);
$result3 = $conn ->query($sql3);
$row = $result->fetch_assoc();
$row2 = $result2->fetch_assoc();
$row3 = $result3->fetch_assoc();
$total_users = $row['total_users'];
$total_menu = $row2['total_menu'];
$total_order = $row3['today_orders'];
?>

<?php
$sql = "SELECT o.*, u.*
FROM orders o
JOIN user_form u ON o.user_id = u.user_id";
$stmt = $conn->prepare($sql);
?>

<div class="main-content">
    <h1>Welcome to the Admin Dashboard</h1>
    <div class="dashboard-summary">
        <div class="summary-card">
            <i class="fas fa-users icon"></i>
            <h3>Total Users</h3>
            <p id="userCount"><?php echo $total_users; ?></p>
        </div>
        <div class="summary-card">
            <i class="fas fa-utensils icon"></i>
            <h3>Total Menu Items</h3>
            <p id="menuCount"><?php echo $total_menu; ?></p>
        </div>
        <div class="summary-card">
            <i class="fas fa-receipt icon"></i>
            <h3>Total Orders</h3>
            <p id="orderCount"><?php echo $total_order;?></p>
        </div>
        <div class="summary-card">
            <i class="fas fa-wallet icon"></i>
            <h3>Total Earnings</h3>
            <p id="totalEarnings">₹12,000</p>
        </div>
    </div>


</div>


<?php include '../includes/layout/footer.php' ?>