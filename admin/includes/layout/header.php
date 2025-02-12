<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <link rel="stylesheet" href="../assets/css/sidebar.css?v=1.0">
    <link rel="stylesheet" href="../assets/css/utility.css?v=1.0">
    <!-- <script src="../assets/js/admin.js" defer></script> -->
    <style>
       
    </style>
</head>
<body>

<?php
    if (!empty($pageStyles)) {
        foreach ($pageStyles as $style) {
            echo "<link rel='stylesheet' href='$style'>";
        }
    }
    ?>

<?php
session_start(); // Start the session
include("../../includes/db.php");
// Check if the user is logged in and has the correct role
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'super_admin') {
    // Redirect to the login page
    header("Location: admin_login.php");
    exit;
}

$id = $_SESSION['id'];

// Admin panel content goes here
// echo "Welcome, " . htmlspecialchars($_SESSION['username']) . "! This is the Admin Panel.";
?>


<?php
include '../includes/layout/sidebar.php';
?>


<!-- profile popup -->

<!-- Popup Form -->
<div id="profilecontainer" class="profile-contain">
<?php
    // Fetch user details
    $select_user = mysqli_query($conn, "SELECT * FROM `admin_user` WHERE id = '$id'") or die("query failed");
    if (mysqli_num_rows($select_user) > 0) {
        $fetch_user = mysqli_fetch_assoc($select_user);
    }
    ?>
    <div class="profile-content">
        <span class="close">&times;</span>
        <h3>Profile</h3>
        <form action="../update-profile.php" id="profileForm" method="post">
            <input type="hidden" id="user_id" name="user-id" value="<?php echo $user['id'] ?>">
             <!-- Username  -->
            <div class="form-field">
                <label for="username">Username*</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($fetch_user['username']); ?>">
            </div>

            <!-- Contact -->
            <div class="form-field">
                <label for="contact">Contact*</label>
                <input type="text" id="contact" name="contact" placeholder="Enter Contact">
            </div>

            <!-- Email -->
            <div class="form-field">
                <label for="email">Email*</label>
                <input type="email" id="email" name="email" placeholder="Enter Email">
            </div>

            <!-- Submit Button -->
             <button type="submit" class="profile-btn primary-btn">Update Profile</button>
             <!-- <a href="logout.php" class="logout-btn secondary-btn">Logout <i class="fa-solid fa-right-from-bracket"></i></a> -->

        </form>
    </div>
</div> 

