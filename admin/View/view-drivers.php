<?php
include '../includes/db.php'; //included database connection file.
?>

<!-- individual css file adding for particular page css -->
<?php
$pageTitle = "Menu";
$pageStyles = [
    "../Assets/css/page/view-drivers.css?v=1.0", // Menu-specific styles
];
include '../includes/layout/header.php';
?>

<div class="main-content">
    <h1>View Items</h1>
    <p><a href="dashboard.php"><i class="fa-solid fa-house"></i> Home</a> / Manage Menu / View Item</p>

    <hr>

    <section class="driver-section">
        <h2>🚚 Meet Our Delivery Heroes</h2>
        <div class="driver-cards">
            <!-- Rohan Sharma -->
            <div class="driver-card">
                <img src="../Assets/images/delivery-boy.png" alt="Rohan Sharma">
                <h3>Rohan Sharma</h3>
                <p>"Always on the move, always on time."</p>
            </div>

            <!-- Suresh Gupta -->
            <div class="driver-card">
                <img src="../Assets/images/delivery-boy2.png" alt="Suresh Gupta">
                <h3>Suresh Gupta</h3>
                <p>"Rain or shine, your order is mine!"</p>
            </div>

            <!-- Amit Varma -->
            <div class="driver-card">
                <img src="../Assets/images/delivery-boy3.png" alt="Amit Varma">
                <h3>Amit Varma</h3>
                <p>"Delivering joy, one meal at a time."</p>
            </div>
        </div>
    </section>


</div>

<!-- footer -->
<?php
include '../includes/layout/footer.php'
?>