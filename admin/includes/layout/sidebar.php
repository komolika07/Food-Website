
<!-- Top Navbar -->
<div class="top-navbar">
    <div class="logo"><img src="../Assets/images/logo.png"></div>
    <div class="dropdown">
        <button>Admin &#9662;</button>
        <div class="dropdown-menu">
            <a href="#" id="settingBtn"><i class="fa-solid fa-gear"></i> Settings</a>
            <a href="#" id="ProfileBtn"><i class="fa-solid fa-user"></i> profile</a>
        </div>
    </div>
</div>



<!-- Sidebar -->

<main class="Admin-main">
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li>
                <a href="#" class="submenu-toggle"><i class="fas fa-utensils"></i> Manage Menu</a>
                <ul class="submenu">
                    <li><a href="add-new-item.php">Add New Item</a></li>
                    <li><a href="view-items.php">View Items</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="submenu-toggle"><i class="fas fa-receipt"></i> Manage Orders</a>
                <ul class="submenu">
                    <li><a href="view-orders.php">View Orders</a></li>
                    <li><a href="view-order-history.php">View Order History</a></li>
                </ul>
            </li>
            <!-- <li>
                <a href="#" class="submenu-toggle"><i class="fas fa-users"></i> Manage Users</a>
                <ul class="submenu">
                    <li><a href="add-user.php">Add User</a></li>
                    <li><a href="edit-user.php">Edit User</a></li>
                    <li><a href="delete-user.php">Delete User</a></li>
                </ul>
            </li> -->
            <li>
                <a href="#" class="submenu-toggle"><i class="fas fa-calendar-alt"></i> Manage Table Reservation</a>
                <ul class="submenu">
                    <li><a href="view_table_bookings.php">View Bookings</a></li>
                    <!-- <li><a href="pending-reservations.php">Pending</a></li>
                    <li><a href="canceled-reservations.php">Canceled</a></li> -->
                </ul>
            </li>
            <li>
                <a href="#" class="submenu-toggle"><i class="fas fa-comments"></i> Manage Feedback</a>
                <ul class="submenu">
                    <li><a href="view-feedback.php">View Feedback</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="submenu-toggle"><i class="fas fa-shipping-fast"></i> Manage Delivery</a>
                <ul class="submenu">
                    <li><a href="view-drivers.php">View Drivers</a></li>
                    <!-- <li><a href="delivery-status.php">View Delivery Status</a></li> -->
                </ul>
            </li>
        </ul>
    </div>

</main>

    