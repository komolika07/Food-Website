
<?php
include '../includes/db.php'; // Include database connection
session_start();
$user_id = $_SESSION['user_id'];

// Redirect to login page if the user is not logged in


?>




<div class="main-container">

        <!-- <div class="title center">
            <h2>My Account</h2>
        </div> -->

        <section class="profile">

            <?php
            // Fetch user details
            $select_user = mysqli_query($conn, "SELECT * FROM `user_form` WHERE user_id = '$user_id'") or die("query failed");
            if (mysqli_num_rows($select_user) > 0) {
                $fetch_user = mysqli_fetch_assoc($select_user);
            }
            ?>

            <aside class="sidebar">
                <div class="user-info">
                    <div class="avatar center">
                        <img src="../../images/user-avatar.avif" alt="User Avatar">
                        <!-- <i class="fas fa-user"></i> -->
                    </div>
                    <div class="user-text">
                        <span>hello,</span>
                        <h3><?php echo htmlspecialchars($fetch_user['f_name']); ?><?php echo " " . htmlspecialchars($fetch_user['l_name']); ?>
                        </h3>
                    </div>
                </div>
                <nav>
                    <ul class="menu">
                        <li class="menu-item" data-item="personal_info">
                            <a href="#"><i class="uil uil-user"></i>Personal Information</a>
                        </li>
                        <li class="menu-item" data-item="my_orders">
                            <a href="#"><i class="uil uil-bag"></i>My Orders</a>
                        </li>
                        <li class="menu-item" data-item="manage_addresses">
                            <a href="#"><i class="uil uil-house-user"></i>Manage Addresses</a>
                        </li>
                        <li class="menu-item" data-item="logout">
                            <a href="#"><i class="uil uil-sign-out-alt"></i>Logout</a>
                        </li>
                    </ul>
                </nav>
                <div id="details"></div>

            </aside>

            <main class="profile-content" id="profile-content">

                <div class="data personal-info"> 
                    <div class="top">
                        <h2>Personal Information</h2>
                        <a href="" class="edit-link">edit</a>
                    </div>
                    <form action="#">
                        <div class="data-field user-name">
                            <div class="first-name name">
                                <label for="first-name">First Name</label>
                                <input type="text" id="first-name" class="input-first-name"
                                    value="<?php echo htmlspecialchars($fetch_user['f_name']); ?>">
                            </div>
                            <div class="last-name name">
                                <label for="last-name">Last Name</label>
                                <input type="text" id="last-name" class="input-last-name"
                                    value="<?php echo htmlspecialchars($fetch_user['l_name']); ?>">
                            </div>
                        </div>
                        <div class="data-field user-gender">
                            <label for="gender">Your Gender</label>
                            <div class="gender-options">
                                <label for="gender-male">
                                    <input type="radio" id="gender-male" name="gender" value="male"> Male
                                </label>
                                <label for="gender-female">
                                    <input type="radio" id="gender-female" name="gender" value="female"> Female
                                </label>
                                <label for="gender-other">
                                    <input type="radio" id="gender-other" name="gender" value="other"> Other
                                </label>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="data email-info">
                    <div class="top">
                        <h2>Email Address</h2>
                        <a href="" class="edit-link">edit</a>
                    </div>
                    <form action="#">
                        <div class="row">
                            <div class="data-field email-field">
                                <input type="email" id="email" class="input-email" name="email">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="data mobile-info">
                    <div class="top">
                        <h2>Mobile Number</h2>
                        <a href="" class="edit-link">edit</a>
                    </div>
                    <form action="#">
                        <div class="row">
                            <div class="data-field mobile-field">
                                <input type="tel" id="mobile" class="input-mobile" value="+91 9876543210">
                            </div>
                        </div>
                    </form>
                </div> 

            </main>

        </section>

    </div>

    <!-- Footer -->
    <?php
    include("../includes/Layout/footer.php");
    ?>

    <!-- <script>
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function (e) {
                document.getElementById('profile-content').innerHTML = "";
                e.preventDefault();
                const itemId = this.getAttribute('data-item');

                // Fetch details using AJAX
                fetch('get_details.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `item=${itemId}`
                })
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('profile-content').innerHTML = data;
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script> -->

</body>

</html>


