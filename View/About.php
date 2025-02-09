<?php
// $pageTitle = "Menu";
$pageStyles = [
    "../assets/css/pages/about.css", // Menu-specific styles
];
include '../includes/Layout/header.php';
// include '../includes/Layout/Loginform.php';
include '../includes/Layout/navbar.php';
?>

<?php
  include "../includes/db.php";
  include "../includes/auth.php";
 ?>

    <section class="Common-sec container">
        <!-- <h3>About <b>Us</b></h3> -->
        <p><a href="HomePage.php"><i class="fa-solid fa-house"></i> Home</a> > About Us</p>
    </section>



    <section class="About-Banner container">
        <div class="About-banner-text">
            <h1>WELCOME!!</h1>
            <h4>Who We Are</h4>
            <p>"DeepSagar is Family chinese Restuarant that works to make your life easier. We take responsiblity for making sure that your orders from restaurants are delivered to you safely and quickly"</p>
            <img src="../assets/images/logo.png">
        </div>

        <img class="banner-image" src="../assets/images/about-banner-img.png">
    </section>

    

   
 <section class="about-last-banner">
        <div class="banner-img">
            <img src="../assets/images/banner-2.png">
        </div>
        <div class="Banner-text">
            <span>#STAY<br> HOME</span>
            <div class="heading">Delivery Or Takeaway</div>

            <div class="partition">
                <div class="Para-part-first">
                    "We've made things doubly easy for you by providing takeaway options as well as door-to-door delivery every day"
                </div>

                <div class="Para-part-sec">
                    we are lucky to live in a glorious age that gives us everything we could ask for as a human race.<br><br>
                    <i class="fa-solid fa-check"></i>click & collect<br>
                    <i class="fa-solid fa-check"></i>Takeaway available<br>
                    <i class="fa-solid fa-check"></i>Home delivery<br>
                </div>
            </div>
        </div>
    </section>
   

    <section class="About-food-items container">
        <div class="dynamic-text">
            <h3>Discover our <span id="changing-word">Tasty</span> Food.</h3>
            <p>Fastest delivery on your doorstep.</p>
        </div>
        <div class="Food-items">
            <div class="item-box">
                <img src="../assets/images/noodles.png">
                <h5>Noodles</h5>
            </div>
            <div class="item-box">
                <img src="../assets/images/lollipop.png">
                <h5>starter</h5>
            </div>
            <div class="item-box">
                <img src="../assets/images/rice.png">
                <h5>Rice</h5>
            </div>
            <div class="item-box">
                <img src="../assets/images/soup.png">
                <h5>Soup</h5>
            </div>
        </div>
    </section>
    

    <section class="About-team-member container">
        <h2>Our Team</h2>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Hic placeat cupiditate, molestias officia minima vel repudiandae magni culpa consectetur laudantium quas, qui praesentium commodi ex fugit accusantium, voluptas voluptatum corrupti.</p>

        <div class="grid-container">
            <div class="grid-box">
                <img src="../assets/images/person 1.png">
                <h4>Kevin Edward</h4>
                <div class="social-media-icon">
                    <a><i class="fa-brands fa-facebook"></i></a>
                    <a><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
            <div class="grid-box">
                <img src="../assets/images/person 2.png">
                <h4>Roxie Gilbert</h4>
                <div class="social-media-icon">
                    <a><i class="fa-brands fa-facebook"></i></a>
                    <a><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
            <div class="grid-box">
                <img src="../assets/images/person3.png">
                <h4>Edgard Johnson</h4>
                <div class="social-media-icon">
                    <a><i class="fa-brands fa-facebook"></i></a>
                    <a><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </section>
    

        <?php include '../includes/Layout/footer.php'; ?>