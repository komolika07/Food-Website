function exploreSite() {
    // Fetch login status from PHP (inserted as a JS variable)
    let isLoggedIn = '<?php echo json_encode($is_logged_in); ?>';

    if (isLoggedIn) {
        window.location.href = "homepage.php"; // Redirect to homepage if logged in
    } else {
        alert("Please log in to access the homepage.");
        window.location.href = "login.php"; // Redirect to login page
    }
}


// Mock login toggle (for testing purposes)
// Uncomment to simulate login
// localStorage.setItem("loggedIn", "true");
