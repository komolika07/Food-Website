

<?php
$pageTitle = "Menu";
$pageStyles = [
    "../assets/css/pages/profile.css?v=1.0", // Menu-specific styles
];
include '../includes/Layout/header.php';
// include '../includes/Layout/Loginform.php';
include '../includes/Layout/navbar.php';
?>

<section class="Common-sec container">
        <h3>My <b>Profile</b></h3>
        <p><a href="HomePage.php">Home</a> / My Profile</p>
</section>

<section class="profile-container">

            <?php
            // Fetch user details
            $select_user = mysqli_query($conn, "SELECT * FROM `user_form` WHERE user_id = '$user_id'") or die("query failed");
            if (mysqli_num_rows($select_user) > 0) {
                $fetch_user = mysqli_fetch_assoc($select_user);
            }
            ?>
        <aside class="sidebar">

                <div class="user-inf">
                    <div class="profile-pic">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="user-text">
                        <span>Hello,</span>
                         <h3> <?php echo htmlspecialchars($fetch_user['f_name']); ?><?php echo " " . htmlspecialchars($fetch_user['l_name']); ?> </h3>
                       <!-- Komolika Dagare  -->
                    </div>
                </div>

            <ul>
                <li onclick="showSection('personal-info')" id="personal-info-tab" class="active"><i class="fas fa-user"></i> Personal Information</li>
                <li onclick="showSection('manage-address')" id="manage-address-tab"><i class="fa-solid fa-location-crosshairs"></i> Manage Address</li>
                <li onclick="showSection('my-orders')" id="my-orders-tab"><i class="fas fa-receipt"></i> My Orders</li>
                <li onclick="showSection('my-table-booking')" id="my-table-book-tab"><i class="fas fa-calendar-alt"></i> Table Booking</li>
                <li onclick="showSection('my-wishlist')" id="my-table-book-tab"><i class="fa-solid fa-heart"></i> My Wishlist</li>
                <li onclick="logout()"><i class="fa-solid fa-right-from-bracket"></i> Logout</li>
            </ul>
        </aside>

        <!-- Content Area -->
        <main class="content">
            <div id="personal-info" class="section active">
                <h2>Personal Information</h2>
                    <form action="#">
                        <div class="profile-field user_name">
                            <div class="f-name name">
                                <label for="first-name">First Name *</label>
                                <input type="text" id="first-name" class="input-first-name"
                                    value="<?php echo htmlspecialchars($fetch_user['f_name']); ?>">
                            </div>
                            <div class="l-name name">
                                <label for="last-name">Last Name *</label>
                                <input type="text" id="last-name" class="input-last-name"
                                    value="<?php echo htmlspecialchars($fetch_user['l_name']); ?>">
                            </div>
                        </div>  
                    </form>


                <div class="data email-info">
                    <form action="#">
                            <div class="profile-field email-field">
                                <label for="email">Email *</label>
                                <input type="email" id="email" class="input-email" name="email"
                                value="<?php echo htmlspecialchars($fetch_user['email']); ?>">
                            </div>
                    </form>
                </div>

                <div class="data phone-info">
                    <form action="#">
                            <div class="profile-field phone-field">
                                <label for="mobile">Phone *</label>
                                <input type="tel" id="mobile" class="input-mobile" >
                            </div>
                    </form>
                </div> 


                <div class="data user-gender">
                        <form action="">
                            <div class="profile-field gender-options">
                                <label for="gender">Gender *</label>
                                    <select required>
                                        <option value="" disabled selected>Select your Gender</option>
                                        <option>Female</option>
                                        <option>Male</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                        </form>
                </div>

                <form action="">
                    <button type="submit" class="primary-btn">Update Changes</button>
                </form>
            </div>

            <div id="manage-address" class="section">
                <h2>Manage Address</h2>
                <p>Add, update, or remove your delivery addresses here.</p>
            </div>

            <div id="my-orders" class="section">
                <h2>My Orders</h2>
                <p>View your past orders and track your current orders here.</p>
            </div>

            <div id="my-table-booking" class="section">
                <h2>My Table Booking</h2>
                <p>View your past orders and track your current orders here.</p>
            </div>

            <div id="my-wishlist" class="section">
                <h2>Wishlist</h2>
                <p>View your past orders and track your current orders here.</p>
            </div>
        </main>
</section>


<?php include '../includes/Layout/footer.php'; ?>