<?php

include '../includes/db.php';

session_start();
$user_id = $_SESSION['user-id'];
if (!isset($user_id)) {
  header('Location: ../view/loginForm.php');
}


?>


<!-- header -->

<section class="upper-section">
  <div class="container flex upper-nav">
    <!-- <div class="contactInfo flex">
          <img src="../assets/images/delivery.png">
         <p>Call for delivery <span>7775055709</span></p>
        </div> -->
    <div class="logo upper-logo">
      <img src="../assets/images/logo.png">
    </div>
    <div class="upper-right flex">
      <?php
      // Fetch user details
      $select_user = mysqli_query($conn, "SELECT * FROM `user_form` WHERE user_id = '$user_id'") or die("query failed");
      if (mysqli_num_rows($select_user) > 0) {
        $fetch_user = mysqli_fetch_assoc($select_user);
      }
      ?>
      <!-- <button class="User-profile" id="User-profile"><a href="#" class="fa-solid fa-user"></a></button> -->
      <button class="User-profile" id="User-profile"><a
          href="../view/profile.php"><span>Hello,</span><?php echo htmlspecialchars($fetch_user['f_name']); ?>
          &#9662;</a></button>

      <!-- <a class="primary-btn Book" id="Book" href="../View/BookTable.php">Book Table</a> -->
      <a href="../view/cart.php" class="icon"> <i class="fa-solid fa-bag-shopping sign"></i></a>
    </div>
  </div>
</section>

<section class="navbar container flex">
  <!-- <div class="logo">
        <img src="../assets/images/logo.png">
      </div> -->

  <div class="category-dropdown">
    <button><i class="fas fa-bars"></i> All Categories &#9662;</button>
    <div class="category-drop">
      <a href="menu.php?category=starter"><i class="fa-solid fa-drumstick-bite"></i> Starter</a>
      <a href="menu.php?category=soup"><i class="fi fi-rr-soup"></i> Soup</a>
      <a href="menu.php?category=noodles"><i class="fi fi-tr-bowl-chopsticks-noodles"></i> Noodles</a>
      <a href="menu.php?category=rice"><i class="fa-solid fa-bowl-rice"></i> Rice</a>
    </div>
  </div>

  <div class="navbar-items flex">
    <ul class="flex" id="navbar-menu">
      <li><a href="../View/HomePage.php" class="component home active">HOME</a></li>
      <li><a href="../View/About.php" class="component about">ABOUT</a></li>
      <li><a href="../View/Menu.php" class="component menu">MENU</a></li>
      <li><a href="../View/Deals.php" class="component deals">DEALS</a></li>
      <li><a href="../View/Contact.php" class="component contact">CONTACT</a></li>
      <li class="dropdown">
        <a href="#" class="component pages"><button class="pageBtn">PAGES&#9662;</button></a>
        <ul class="dropdown-menu">
          <li><a href="profile.php?section=my-orders"><i class="fa-solid fa-box"></i> My Orders</a></li>
          <li><a href="profile.php?section=my-table-booking"><i class="fa-solid fa-calendar-check"></i> My Table Booking</a></li>
          <li><a href="profile.php?section=my-wishlist"><i class="fa-solid fa-heart"></i> Wishlist</a></li>
        </ul>
      </li>
    </ul>
    <div class="navbar-right flex">
      <a class="secondary-btn book" id="book" href="../View/BookTable.php">Book Table</a>
    </div>
  </div>


  <div id="menu-icon"><i class="fas fa-bars" id="toggler"></i></div>
</section>