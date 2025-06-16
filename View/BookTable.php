<?php
$pageTitle = "Menu";
$pageStyles = [
    "../assets/css/pages/BookTable.css?v=2.0", // Menu-specific styles
];
include '../includes/Layout/header.php';
// include '../includes/Layout/Loginform.php';
include '../includes/Layout/navbar.php';
?>
<?php
  include "../includes/db.php";
  include "../includes/auth.php";
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


<!-- Alert msg  -->
<div id="custom-alert" class="alert-msg hidden">

</div>




    <section class="Common-sec">
        <!-- <h3>Book <b>Table</b></h3> -->
        <p><a href="HomePage.php"><i class="fa-solid fa-house"></i> Home</a> > Book Table</p>
    </section>

    <section class="Book-table-form">
        <h1>Book a Table</h1>
        <p>Just a few clicks to make the reservation online for saving your time and money</p>
        <form action="../includes/book_table.php" method="POST">
        <!-- Name -->
        <input type="hidden" id="users-id" name="user_id" value="<?php echo $_SESSION['user-id']; ?>">

                <div class="form-group">
                    <input type="text" id="name" name="name" placeholder="Enter your name" required>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                    
                    <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                </div>

                <!-- Email -->
                <!-- <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                </div> -->

                <!-- Date -->
                <div class="form-group">
                  
                    <input type="date" id="date" name="date" placeholder="Select Date" required>
                    <input type="time" id="time" name="time" placeholder="Select Time" required>
                    <select id="guests" name="guests" required>
                        <option value="" disabled selected>Select number of guests</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6+">6+</option>
                    </select>
                </div>

                <!-- Time -->
                <!-- <div class="form-group">
                   
                </div> -->

                <!-- Number of Guests -->
                <!-- <div class="form-group">
                   
                </div> -->

                <!-- Special Requests -->
                <div class="form-group">
                    <textarea id="requests" name="request" placeholder="Add any special requests"></textarea>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="primary-btn" id="book-table-btn" style="width:100%;">Book Table</button>
                </div>
        </form>
    </section>

    <?php include ('../includes/Layout/footer.php'); ?>