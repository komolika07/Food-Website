<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/your-path-to-uicons/css/uicons-[your-style].css" rel="stylesheet">
    <link href="/your-path-to-uicons/css/uicons-rounded-regular.css" rel="stylesheet">
  <link href="/your-path-to-uicons/css/uicons-rounded-bold.css" rel="stylesheet">
  <link href="/your-path-to-uicons/css/uicons-rounded-solid.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/index.css?v=1.0">
    <title>Document</title>
</head>

<?php
session_start(); // Start the session
$is_logged_in = isset($_SESSION['user_id']); // Assuming 'user_id' is set when user logs in
?>

<body>
    <header class="hero">
        <nav class="navbar">
            <div class="container">
                <div class="logo">
                    <img src="../assets/images/logo.png" alt="Logo">
                </div>
                <button class="login-btn" onclick="redirectToLogin()">Login</button>
            </div>
        </nav>

        <div class="hero-content">
            <h1>Authentic Chinese Cuisine</h1>
            <!-- <p>Delight in the finest flavors of traditional Chinese food, freshly made and delivered to your door.</p> -->
             <div class="explore">
             <button class="explore-btn" onclick="exploreSite()">Explore</button>
                <span> or </span>
            <div class="phone">
                <p>order by phone</p>
                <span>1-800-700-600</span>
            </div>
             </div>
        </div>
    </header>

    <div class="index-content">
        <div class="cards-container">
            <div class="card">
                <img src="../assets/images/taste.png" alt="Icon">
                <h3>Unique Taste</h3>
                <p>Leverage agile frameworks to provide a robust...</p>
            </div>
            <div class="card">
            <img src="../assets/images/clickncollect.png" alt="Icon">
                <h3>Click & Collect</h3>
                <p>Leverage agile frameworks to provide a robust...</p>
            </div>
            <div class="card">
            <img src="../assets/images/deliveryindex.png" alt="Icon">

                <h3>Home Delivery</h3>
                <p>Leverage agile frameworks to provide a robust...</p>
            </div>
            <div class="card">
                <img src="../assets/images/payment.png" alt="Icon">
                <h3>Easy Payment</h3>
                <p>Leverage agile frameworks to provide a robust...</p>
            </div>
        </div>

    </div>

    <footer class="footer">
        <p>&copy; DeepSagar 2024 All Rights Reserved
        </p>
    </footer>

    <script src="../assets/js/index.js" defer></script>
</body>

</html>



