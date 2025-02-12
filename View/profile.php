<?php
$pageTitle = "Menu";
$pageStyles = [
    "../assets/css/pages/profile.css?v=1.0", // Menu-specific styles
];
include '../includes/Layout/header.php';
// include '../includes/Layout/Loginform.php';
include '../includes/Layout/navbar.php';
?>
<?php
include "../includes/db.php";

$user_id = $_SESSION['user-id'];
if (!isset($user_id)) {
    header('location:../view/loginForm.php');
}

// managing address

$sql = "SELECT COUNT(*) as address_count FROM user_addresses WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($address_count);
$stmt->fetch();
$stmt->close();

if ($address_count > 3) {
    // You can display a message or disable the Add Address button
    $max_addresses_reached = true;
} else {
    $max_addresses_reached = false;
}

?>

<?php
if (isset($_SESSION['alert'])):
    $message = $_SESSION['alert']['message'];
    $type = $_SESSION['alert']['type'];
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            showAlert("<?php echo htmlspecialchars($message); ?>", "<?php echo $type; ?>");
        });
    </script>
    <?php
    unset($_SESSION['alert']); // Clear the alert message after showing it
endif;
?>

<?php
// Fetch table bookings for the logged-in user
$bookings_query = "SELECT * FROM table_bookings WHERE user_id = ? ORDER BY booking_date DESC";
$stmt = $conn->prepare($bookings_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$bookings_result = $stmt->get_result();

$bookings = [];
if ($bookings_result->num_rows > 0) {
    while ($row = $bookings_result->fetch_assoc()) {
        $bookings[] = $row;
    }
}
$stmt->close();
?>


<!-- Alert msg  -->
<div id="custom-alert" class="alert-msg hidden">

</div>

<section class="Common-sec container">
    <!-- <h3>My <b>Profile</b></h3> -->
    <p><a href="HomePage.php"><i class="fa-solid fa-house"></i> Home</a> > Profile</p>
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
                <h3> <?php echo htmlspecialchars($fetch_user['f_name']); ?><?php echo " " . htmlspecialchars($fetch_user['l_name']); ?>
                </h3>
                <!-- Komolika Dagare  -->
            </div>
        </div>

        <ul>
            <li onclick="showprofileSection('personal-info')" id="personal-info-tab" class="active"><i
                    class="fas fa-user"></i> Personal Information</li>
            <li onclick="showprofileSection('manage-address')" id="manage-address-tab"><i
                    class="fa-solid fa-location-crosshairs"></i> Manage Address</li>
            <li onclick="showprofileSection('my-orders')" id="my-orders-tab"><i class="fas fa-receipt"></i> My Orders
            </li>
            <li onclick="showprofileSection('my-table-booking')" id="my-table-booking-tab"><i
                    class="fas fa-calendar-alt"></i> Table Booking</li>
            <li onclick="showprofileSection('my-wishlist')" id="my-wishlist-tab"><i class="fa-solid fa-heart"></i> My
                Wishlist</li>
            <li onclick="logout()"><i class="fa-solid fa-right-from-bracket"></i> Logout</li>
        </ul>
    </aside>

    <!-- Content Area -->
    <main class="content">
        <div id="personal-info" class="section active">
            <h2>Personal Information</h2>


            <form action="../includes/update_profile.php" method="POST">
                <div class="profile-field user_name">
                    <div class="f-name name">
                        <label for="first-name">First Name *</label>
                        <input type="text" id="first-name" class="input-first-name" name="first_name"
                            value="<?php echo htmlspecialchars($fetch_user['f_name']); ?>" required>
                    </div>
                    <div class="l-name name">
                        <label for="last-name">Last Name *</label>
                        <input type="text" id="last-name" class="input-last-name" name="last_name"
                            value="<?php echo htmlspecialchars($fetch_user['l_name']); ?>" required>
                    </div>
                </div>

                <div class="data email-info">
                    <div class="profile-field email-field">
                        <label for="email">Email *</label>
                        <input type="email" id="email" class="input-email" name="email"
                            value="<?php echo htmlspecialchars($fetch_user['email']); ?>" required>
                    </div>
                </div>

                <div class="data phone-info">
                    <div class="profile-field phone-field">
                        <label for="mobile">Phone *</label>
                        <input type="tel" id="mobile" class="input-mobile" name="phone_number"
                            value="<?php echo htmlspecialchars($fetch_user['phone_number']); ?>" required
                            maxlength="15">
                    </div>
                </div>

                <div class="data user-gender">
                    <div class="profile-field gender-options">
                        <label for="gender">Gender *</label>
                        <select id="gender" name="gender" required>
                            <option value="" disabled>Select your Gender</option>
                            <option value="Female" <?php echo ($fetch_user['gender'] == 'Female') ? 'selected' : ''; ?>>
                                Female</option>
                            <option value="Male" <?php echo ($fetch_user['gender'] == 'Male') ? 'selected' : ''; ?>>Male
                            </option>
                            <option value="Other" <?php echo ($fetch_user['gender'] == 'Other') ? 'selected' : ''; ?>>
                                Other</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="primary-btn">Update Changes</button>
            </form>

        </div>

        <div id="manage-address" class="section">
            <h2>Manage Address</h2>
            <div id="address-list">
                <?php
                // Include PHP code to display addresses here
                include "../includes/displayAddresses.php";
                ?>
                <!-- Address forms will appear here -->
            </div>

            <?php if (!$max_addresses_reached): ?>
                <button type="button" id="add-address-btn" class="secondary-btn"
                    data-user-id="<?php echo $_SESSION['user-id']; ?>"><i class="fa-solid fa-plus"></i> Add Address</button>

            <?php else: ?>
                <p>You can only add up to 3 addresses.</p>
            <?php endif; ?>


            <div id="edit-form-modal" class="modal hidden">
                <div class="modal-content">
                    <h3>Edit Address</h3>
                    <form id="edit-address-form" action="../includes/edit-address.php" method="post">
                        <!-- Hidden Input for Address ID -->
                        <input type="hidden" id="edit-address-id" name="id">

                        <div class="input">
                            <label for="edit-user-name">Name*</label>
                            <input type="text" id="edit-user-name" name="user-name" required>
                        </div>

                        <div class="input">
                            <label for="edit-phone">Phone*</label>
                            <input type="text" id="edit-phone" name="phone" maxlength="15">
                        </div>

                        <div class="input">
                            <label for="edit-address-line">Address Line*</label>
                            <input type="text" id="edit-address-line" name="address_line" required>
                        </div>
                        <div class="flex">
                            <div class="input">
                                <label for="edit-city">City*</label>
                                <input type="text" id="edit-city" name="city" required>
                            </div>
                            <div class="input">
                                <label for="edit-state">State*</label>
                                <input type="text" value="Maharashtra" disabled>
                                <input type="hidden" id="edit-state" name="state" value="Maharashtra">
                            </div>
                            <div class="input">
                                <label for="edit-zip">ZIP Code*</label>
                                <input type="text" id="edit-zip" name="zip" required>
                            </div>
                        </div>

                        <div class="actions">
                            <button type="submit" class="primary-btn">Save Changes</button>
                            <button type="button" id="cancel-edit-btn" class="secondary-btn">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <div id="my-orders" class="section">
            <h2>My Orders</h2>
            <p>View your past orders and track your current orders here.</p>
        </div>

        <div id="my-table-booking" class="section">
            <h2>My Table Bookings</h2>

            <div class="booking-card-container">
                <?php if (!empty($bookings)): ?>
                    <?php foreach ($bookings as $booking): ?>
                        <div class="booking-card">
                            <h4 class="Booking_id">
                                #Booking Id : <?php echo htmlspecialchars($booking['booking_id']) ?>
                            </h4>
                            <h5 class="booking_date">
                                Booking Date: <?php echo htmlspecialchars($booking['booking_date']); ?>
                                at <?php echo htmlspecialchars($booking['booking_time']); ?>
                            </h5>
                            <p><strong>Guests:</strong> <?php echo htmlspecialchars($booking['guests']); ?></p>
                            <p><strong>Special Requests:</strong>
                                <?php echo !empty($booking['special_requests']) ? htmlspecialchars($booking['special_requests']) : 'None'; ?>
                            </p>
                            <p><strong>Status:</strong>
                                <span class="status-<?php echo strtolower($booking['status']); ?>">
                                    <?php echo htmlspecialchars($booking['status']); ?>
                                </span>
                            </p>
                            <?php if ($booking['status'] == 'Accepted'): ?>
                                <p><strong>Table Number:</strong> <?php echo htmlspecialchars($booking['table_number']); ?></p>
                            <?php endif; ?>

                            <?php if ($booking['status'] == 'Pending'): ?>

                                <button type="submit" class="cancel-btn primary-btn" data-id=<?php echo htmlspecialchars($booking['booking_id']); ?>>Cancel Booking</button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-table-booking">
                        <img src="../assets/images/bookTable3.png">
                        <p>You have no table bookings</p>
                        <a href="BookTable.php" class="primary-btn">Book Table</a>
                    </div>

                <?php endif; ?>
            </div>

        </div>

        <div id="my-wishlist" class="section">
            <h2>Wishlist</h2>
            <div id="wishlist-container" class="wishlist-container">
                
            </div>
        </div>
    </main>
</section>


<?php include '../includes/Layout/footer.php'; ?>