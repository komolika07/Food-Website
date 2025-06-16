<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="../Assets/css/page/Login.css">
</head>

<!-- session message handling -->
<?php
session_start();
$message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
unset($_SESSION['message']); // Clear the message after displaying it
?>


<body>
    <!-- admin-form -->
    <div class="main">

        <section class="Admin-form-section">
            <div class="Admin-content">
                <img src="../Assets/images/logo.png">
                <span>WELCOME!!</span>
            </div>

            <div class="Admin-Form" id="admin-form">
                <div class="form">
                    <h2>Admin Login</h2>
                    <form action="../includes/login.php" method="POST">
                        <div class="Error_msg">
                            <!-- <i class="fas fa-exclamation-triangle"></i> This is Error msg -->

                            <?php if ($message): ?>
                                <div class="alert <?= htmlspecialchars($message['type']) ?>">
                                    <?= htmlspecialchars($message['text']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-field Role">
                            <i class="fa-solid fa-user"></i>
                            <select id="role" name="role" required>
                                <option value="" disabled selected>Select your role</option>
                                <option value="super_admin">Super Admin</option>
                                <option value="delivery_person">Delivery Person</option>
                            </select>
                        </div>
                        <div class="form-field Username">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" id="Username" name="admin-username" placeholder="Enter Username">
                        </div>

                        <div class="form-field password">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" id="Admin-pass" name="admin-password" placeholder="Enter Password">
                        </div>
                        <div class="Forget-pass">
                            <a href="#">Forget password?</a>
                        </div>
                        <button class="login-form-btn">Login</button>

                    </form>
                </div>
            </div>




        </section>
    </div>

</body>

</html>