<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chinese Food Landing Page</title>
    <link rel="stylesheet" href="../assets/css/index.css?v=1.0">

    <?php
    if (!empty($pageStyles)) {
        foreach ($pageStyles as $style) {
            echo "<link rel='stylesheet' href='$style'>";
        }
    }
    ?>

</head>
<body>

<!-- Navbar -->
<nav class="navbar">
        <div class="container">
            <div class="logo">
                <img src="../assets/images/logo.png" alt="Logo">
            </div>
            <button class="login-btn" onclick="redirectToLogin()">Login</button>
        </div>
</nav>


