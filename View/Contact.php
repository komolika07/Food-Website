<?php
$pageTitle = "Menu";
$pageStyles = [
  "../assets/css/pages/Contact.css?v=1.0", // Menu-specific styles
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


<section class="Common-sec container">
  <!-- <h3>Contact <b>Us</b></h3> -->
  <p><a href="HomePage.php"><i class="fa-solid fa-house"></i> Home</a> > Contact </p>
</section>

<section class="contact-section container">
  <div class="services" id="services">
    <div class="service" id="service1">
      <img src="../assets/images/delivery2.png">
      <div class="service-detail">
        <h4>Free Shipping</h4>
        <p>Free shipping upto 2km. Also sign up for updates and get free shipping</p>
      </div>
    </div>
    <div class="service" id="service2">
      <img src="../assets/images/time.png">
      <div class="service-detail">
        <h4>30 Minutes Delivery</h4>
        <p>Everything you order will quickly delivered to your door</p>
      </div>
    </div>
    <div class="service" id="service3">
      <img src="../assets/images/parcel.png">
      <div class="service-detail">
        <h4>Best Quality Guarantee</h4>
        <p>We Provide a Best Quality Delivered to You</p>
      </div>
    </div>
  </div>


  <div class="contacts" id="contacts-info">
    <div class="contact-details" id="contact-details">
      <div class="detail address-block">
        <i class="fas fa-location-dot"></i>
        <h4>ADDRESS LINE</h4>
        <p>Satpayari-devgad Tal. Devgad, Dist. Sindhurdurg.</p>
      </div>
      <div class="detail numbers-block">
        <i class="phone fas fa-phone"></i>
        <h4>Contact</h4>
        <p>7775055709 / 9503405709</p>
        <p>deepSagarRestro@gmail.com</p>
      </div>
      <div class="detail time-block">
        <i class="fas fa-clock"></i>
        <h4>Hour of Operation</h4>
        <p> Monday-Sunday</p>
        <p> Time : 12 PM - 11 PM
      </div>

    </div>

    <div class="feedback" id="feedback-form">
      <div>
        <h2>Get In Touch With Us!</h2>
        <p>Feel free what problems you have faced. Your feedback matters us.</p>
      </div>

      <div class="form">
        <form action="../includes/manageFeedback.php" method="POST">
          <input type="hidden" id="users-id" name="user_id" value="<?php echo $_SESSION['user-id']; ?>">
          <div class="contact-field username">
            <input type="text" id="contact-name" name="user_name" placeholder="FirstName">
            <input type="text" id="contact-lname" name="user_lname" placeholder="LastName">
          </div>
          <div class="contact-field email">
            <input type="email" id="contact-email" name="user_email" placeholder="Enter Email">
          </div>

          <div class="contact-field message">
            <textarea id="message" name="feedback_message" placeholder="Enter your message"></textarea>
          </div>

          <button class="feedback-btn primary-form-btn" id="feedback-btn">Submit</button>

        </form>
      </div>
    </div>
  </div>
</section>

<div class="template" id="template">
  <div class="template-content">
    <h4>We Guarantee</h4>
    <h2>30 Minutes Delivery!</h2>
    <p>you're having a meeting, working late at night, need an extra push. <br> Let us know and we will be there</p>
    <button class="primary-btn">Order Now <i class="fa-solid fa-arrow-right"></i></button>
  </div>
  <img src="../assets/images/deliveryboy.png">
</div>


<?php include '../includes/Layout/footer.php'; ?>