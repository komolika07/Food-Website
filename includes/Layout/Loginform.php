


<section class="form-section">

<div class="form-container" id="signup-form" style="display: none;">
    <i class="fas fa-times" id="cross"></i>
    <div class="form">
        <h2>Register</h2>
        <h3>We Serve You The Best Food!</h3>
        <form action="" method="post">
            <div class="Error_msg">
                <!-- <i class="fas fa-exclamation-triangle"></i> This is Error msg -->
            </div>
           
            <div class="login-field Username">
                <i class="fa-solid fa-user"></i>
                <input type="text" id="signup-name" name="name" placeholder="FirstName">
                <input type="text" id="signup-lname" name="lname" placeholder="LastName">
            </div>
            <!-- <div class="login-field phone">
                <i class="fa-solid fa-phone"></i>
                <input type="text" id="signup-phone" name="phone" placeholder="Enter Phone Number">
            </div> -->
            <div class="login-field email">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" id="signup-email" name="email" placeholder="Enter Email">
            </div>

            <div class="login-field password">
                <i class="fa-solid fa-lock"></i>
                <input type="password" id="signup-password" name="password" placeholder="Enter Password">
            </div>

            <button class="sign-in primary-form-btn">Register</button>
            <div class="link">
                Already have an account? <button id="login" class="form-btn ">Sign-in</button>
            </div>
        </form>
    </div>
</div>



<div class="form-container " id="login-form">
    <i class="fas fa-times" id="cross1"></i>
    <div class="form">
        <h2>Login</h2>
        <h3>We Serve You The Best Food!</h3>
        <form action="" method="post">
            <div class="Error_msg">
                <i class="fas fa-exclamation-triangle"></i> This is Error msg
            </div>
            <div class="login-field email">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" id="login-email" name="email" placeholder="Enter Email">
            </div>

            <div class="login-field password">
                <i class="fa-solid fa-lock"></i>
                <input type="password" id="login-password" name="password" placeholder="Enter Password">
            </div>
            <div class="Forget">
                <a href="#">Forget password?</a>
            </div>
            <button class="sign-in primary-form-btn">Login</button>

            <div class="link">
                Don't have an account? <button id="Register" class="form-btn">Sign up</button>
            </div>
        </form>
    </div>
</div>

</section>