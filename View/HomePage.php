
<?php
$pageTitle = "Menu";
$pageStyles = [
    "../assets/css/pages/homePage.css", // Menu-specific styles
];

include '../includes/Layout/header.php';
// include '../includes/Layout/Loginform.php';
include '../includes/Layout/navbar.php';
?>
 

<!-- hero-session  -->

<section class="hero-session container">
      <div class="carousel">
        <div class="slides flex">

          <div class="slide container flex">
            <div class="slider-image">
              <img src="../assets/images/imggg.png" class="img">
            </div>
            <div class="msg"><i class="fa-solid fa-check"></i> Your Food on delivery</div>
            <div class="content">
              <h1 class="content-header">Enjoy Your <b>Food</b> Without Leaving The House </h1>
              <p class="content-para"> Satisfy your cravings without stepping out - indulge in a diverse culinary
                experience straight to your doorstep elevate your home dining with a menu that caters to your taste</p>
              <a class="orderBtn primary-btn btn">Order Now</a>
              <a class="ExploreBtn secondary-btn btn">Explore Menu</a>

              <!-- <div class="bgimg2" style="background-image: url(../Home/images/bgimg2.png);"></div>  -->
            </div>
          </div>



          <div class="slide flex">
            <div class="slider-image">
              <img src="../assets/images/slider_3.png" class="img">
              <!-- <div class="bgimg" style="background-image: url(./homepage/images/bgimg.png);"></div>
            <div class="bgimg3" style="background-image: url(./homepage/images/bgimg3.png);"></div> -->
            </div>
            <div class="msg"><i class="fa-solid fa-check"></i> Easy Reservation</div>
            <div class="content">
              <h1 class="content-header">Reserve <b>Your Table </b> Without Leaving The House </h1>
              <p class="content-para"> Get Your Reservation done in just a few click without leaving the house and save
                your time and money</p>
              <a class="Reservebtn primary-btn btn">Reserve Table</a>
              <a class="takeAwayBtn  secondary-btn btn">Takeaway</a>
              <!-- <div class="bgimg2" style="background-image: url(./homepage/images/bgimg2.png);"></div>           -->
            </div>
          </div>


          <div class="slide flex">
            <div class="slider-image">
              <img src="../assets/images/slider_2.png" class="img">
              <!-- <div class="bgimg" style="background-image: url(./homepage/images/bgimg.png);"></div> -->
              <!-- <div class="bgimg3" style="background-image: url(./homepage/images/bgimg3.png);"></div> -->
            </div>
            <div class="msg"><i class="fa-solid fa-check"></i> Best Deals</div>
            <div class="content">
              <h1 class="content-header"> Enjoy Our Daily <b>Best Deals</b> and<b> Services</b></h1>
              <p class="content-para">Place Your Order And Get 10% Discount Upto *₹150 with free shipping charges.<br>
                View More Deals</p>
              <a class="primary-btn DealsBtn btn">View Deals</a>
              <!-- <div class="bgimg2" style="background-image: url(./homepage/images/bgimg2.png);"></div>           -->
            </div>
          </div>

        </div>
        <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
        <button class="next" onclick="moveSlide(1)">&#10095;</button>
      </div>
    </section>


    <!-- how it works  -->

    <section class="order-steps container flex">
      <div class="context">
        <h1 class="context-header">Get <b>Your food</b> In Less Than An Hour</h1>
        <P class="context-para">Delicious dishes delivered to your doorstep in under an hour satisfy your craving with
          swift &
          savory services.
        </P>
        <button class="explore-menu primary-btn">Explore Menu</button>
      </div>
      <div class="step step1">
        <h3 class="number">01</h3>
        <h4>Explore Our Menu</h4>
        <p>Enhance your dining experience, explore our diverse chinese cuisines and order your favourite food
          seamlessly </p>
      </div>
      <div class="step step2n3 flex">
        <div class="step2">
          <h3 class="number">02</h3>
          <h4>Select Your Food</h4>
          <p>Select your food, embark on a culinary journey tailored to your taste buds </p>
        </div>
        <div class="step3">
          <h3 class="number">03</h3>
          <h4>Confirm Your Order</h4>
          <p>confirm your order and savor the anticipation of the delicious culinary experience </p>
        </div>
      </div>
    </section>

    <!-- quick pick category  -->
     <!-- <section class="quick-pick-menu container">
      <div class="category">
        <h4><b>Quick Pick</b></h4>
        <h1>Popular Goods</h1>
        <ul class="menu-category" id="menu-category">
          <li class="Starter active" data-target="Starter"><img src="../Home/images/2.png">Starter</li>
          <li class="Soup" data-target="Soup"><img src="../Home/images/3.png">Soup</li>
          <li class="Noodles" data-target="Noodles"><img src="../Home/images/1.png">Noodles</li>
          <li class="Rice" data-target="Rice"><img src="../Home/images/4.png">Rice</li>
        </ul>
      </div>

      <div class="menu-content">

        <div class="Menu-cards-container Starter" id="Starter" style="display: none;">

          Starter
        </div>

        <div class="Menu-cards-container Soup" id="Soup" style="display: none;">
          Soup
        </div>
        <div class="Menu-cards-container Noodles" id="Noodles" style="display: none;">
          Noodles
        </div>

        <div class="Menu-cards-container Rice" id="Rice" style="display: none;">
          Rice
        </div>

      </div>
    </section> -->

    <!-- Deals section -->

    <section class="Deals-section container">
      <h3>Our <b>Deals</b></h3>
      <div class="Deals-container">
        <div class="deal-card commoncard">
          <button class="view-button">View Deals</button>
        </div>
        <img src="../assets/images/COMBO.png">
        <div class="deal-card2 commoncard">
          <button class="view-button">View Deals</button>
        </div>
      </div>
        <button class="View-deals primary-btn">View Deals <i class="fa-solid fa-arrow-right"></i></button>
    </section>
<!-- customer review  -->

<section class="customer-review container">
  <h3>Our <b>Happy Customers</b></h3>
  <div class="customer-review-cards">
    <div class="feedback-container">
      <div class="feedback-carousel">
        <div class="feedback-card">
          <p class="feedback-text">"Great service and delicious food! Will order again."</p>
          <div class="feedback-info">
            <span class="client-name">- John Doe</span>
            <span class="rating">⭐⭐⭐⭐⭐</span>
          </div>
        </div>
        <div class="feedback-card">
          <p class="feedback-text">"Fast delivery and friendly staff. Highly recommended!"</p>
          <div class="feedback-info">
            <span class="client-name">- Sarah Lee</span>
            <span class="rating">⭐⭐⭐⭐</span>
          </div>
        </div>
        <div class="feedback-card">
          <p class="feedback-text">"Quality could be better, but overall decent experience."</p>
          <div class="feedback-info">
            <span class="client-name">- Anonymous</span>
            <span class="rating">⭐⭐⭐</span>
          </div>
        </div>
      </div>
      <button class="prev-btn">❮</button>
      <button class="next-btn">❯</button>
    </div>
  </div>  
</section>


<!-- feedback-form -->
<!-- <section class="feedback-form container" id="feedback-form">
  <h4>Let Us Know! <br> <b>Have You Enjoy Your Food!!</b></h4>

  <div class="feedform">
    <form>
      <input type="text" class="comment" id="comment" placeholder="Your Comment">
      <button class="Submit-btn">Submit</button>
    </form>
  </div>

</section> -->

<?php include '../includes/Layout/footer.php'; ?>