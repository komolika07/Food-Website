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

    <div class="form-container" id="signup-form">
        <i class="fas fa-times" id="cross"></i>
        <div class="form">
            <h2>Register</h2>
            <h3>We Serve You The Best Food!</h3>
            <form action="../includes/RegisterUser.php" method="POST" enctype="multipart/form-data">
                <div class="Error_msg">
                    <!-- <i class="fas fa-exclamation-triangle"></i> This is Error msg -->
                    <?php if ($message): ?>
                    <div class="alert <?= htmlspecialchars($message['type']) ?>">
                        <?= htmlspecialchars($message['text']) ?>
                    </div>
                <?php endif; ?>
                </div>
            
                <div class="login-field Username">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" id="signup-name" name="name" placeholder="FirstName" required>
                    <input type="text" id="signup-lname" name="lname" placeholder="LastName" required >
                </div>
                <!-- <div class="login-field phone">
                    <i class="fa-solid fa-phone"></i>
                    <input type="text" id="signup-phone" name="phone" placeholder="Enter Phone Number">
                </div> -->
                <div class="login-field email">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" id="signup-email" name="email" placeholder="Enter Email" required>
                </div>

                <div class="login-field password">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="signup-password" name="password" placeholder="Enter Password" required>
                </div>

                <button class="sign-in primary-form-btn">Register</button>
                <div class="link">
                    Already have an account? <a href="loginForm.php" id="login" class="form-btn ">Sign-in</a>
                </div>
            </form>
        </div>
    </div>

</section>
<?php include '../includes/Layout/indexFooter.php'; ?>

