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