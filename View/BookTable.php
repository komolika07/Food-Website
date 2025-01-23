<?php
$pageTitle = "Menu";
$pageStyles = [
    "../assets/css/pages/BookTable.css?v=2.0", // Menu-specific styles
];
include '../includes/Layout/header.php';
// include '../includes/Layout/Loginform.php';
include '../includes/Layout/navbar.php';
?>

    <section class="Common-sec container">
        <h3>Book <b>Table</b></h3>
        <p><a href="HomePage.php">Home</a> / Book Table</p>
    </section>

    <section class="Book-table-form">
        <h1>Book a Table</h1>
        <p>Just a few clicks to make the reservation online for saving your time and money</p>
        <form action="book_table.php" method="POST">
        <!-- Name -->
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
                    <textarea id="requests" name="requests" placeholder="Add any special requests"></textarea>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="primary-btn" id="book-table-btn" style="width:100%;">Book Table</button>
                </div>
        </form>
    </section>

    <?php include ('../includes/Layout/footer.php'); ?>