<!-- <?php
// session_start(); // Start the session

// // Check if the user is logged in and has the correct role
// if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'super_admin') {
//     // Redirect to the login page
//     header("Location: admin_login.php");
//     exit;
// }

// Admin panel content goes here
// echo "Welcome, " . htmlspecialchars($_SESSION['username']) . "! This is the Admin Panel.";
?> -->
<?php
$pageTitle = "Menu";
$pageStyles = [
    "../Assets/css/page/dashboard.css?v=1.0", // Menu-specific styles
];
include '../includes/layout/header.php';
?>




    <div class="main-content">
        <h1>Welcome to the Admin Dashboard</h1>
        <p>Manage your website content and settings from here.</p>
    </div>


    <?php 
    include '../includes/layout/footer.php'
    ?>