<?php
$pageTitle = "Menu";
$pageStyles = [
    "../assets/css/pages/Register.css?v=2.0", // Menu-specific styles
];


include '../includes/Layout/indexNav.php';
?>

<?php
session_start();
$message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
unset($_SESSION['message']); // Clear the message after displaying it
?>

<section class="form-section">
<div class="form-container " id="login-form">
    <i class="fas fa-times" id="cross1"></i>
    <div class="form">
        <h2>Login</h2>
        <h3>We Serve You The Best Food!</h3>
        <form action="../includes/loginUser.php" method="POST" enctype="multipart/form-data">
            <div class="Error_msg">
                <!-- <i class="fas fa-exclamation-triangle"></i> This is Error msg -->
                <?php if ($message): ?>
                    <div class="alert <?= htmlspecialchars($message['type']) ?>">
                        <?= htmlspecialchars($message['text']) ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="login-field email">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" id="login-email" name="email" placeholder="Enter Email" required>
            </div>

            <div class="login-field password">
                <i class="fa-solid fa-lock"></i>
                <input type="password" id="login-password" name="password" placeholder="Enter Password" required>
            </div>
            <div class="Forget">
                <a href="#">Forget password?</a>
            </div>
            <button class="sign-in primary-form-btn">Login</button>

            <div class="link">
                Don't have an account? <a href="RegisterForm.php" id="Register" class="form-btn">Sign up</a>
            </div>
        </form>
    </div>
</div>

</section>

<?php include '../includes/Layout/indexFooter.php'; ?>