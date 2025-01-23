
 <?php 

include '../includes/db.php';

session_start();
$user_id = $_SESSION['user-id'];
if(!isset($user_id)){
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
          <button class="User-profile" id="User-profile"><a href="#" ><span>Hello,</span><?php echo htmlspecialchars($fetch_user['f_name']); ?> &#9662;</a></button>

          <!-- <a class="primary-btn Book" id="Book" href="../View/BookTable.php">Book Table</a> -->
           <a href="#" class=" icon fa-solid fa-bag-shopping sign"> Cart</a>
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
                <a href="#"><i class="fa-solid fa-right-from-bracket"></i> Starter </a>
                <a href="#"><i class="fa-solid fa-gear"></i> Rice</a>
                <a href="#"><i class="fa-solid fa-right-from-bracket"></i> Noodles</a>
                <a href="#"><i class="fa-solid fa-right-from-bracket"></i> soup</a>
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
                        <li><a href="../View/MyOrders.php"><i class="fa-solid fa-box"></i> My Orders</a></li>
                        <li><a href="../View/TableBooking.php"><i class="fa-solid fa-calendar-check"></i> My Table Booking</a></li>
                        <li><a href="../View/Wishlist.php"><i class="fa-solid fa-heart"></i> Wishlist</a></li>
                    </ul>
                </li>
            </ul>
          <div class="navbar-right flex">
              <a class="secondary-btn book" id="book" href="../View/BookTable.php">Book Table</a>
          </div>
        </div>


      <div id="menu-icon"><i class="fas fa-bars" id="toggler"></i></div>
    </section>

