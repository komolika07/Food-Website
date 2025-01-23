// Check if the user is logged in (mock function)
function isLoggedIn() {
    // Replace with actual login status check logic
    return localStorage.getItem("loggedIn") === "true";
}

// Redirect to login page
function redirectToLogin() {
    window.location.href = "loginForm.php"; // Replace with the actual login page URL
}

// Handle "Explore" button click
function exploreSite() {
    if (isLoggedIn()) {
        window.location.href = "HomePage.php"; // Replace with the main website URL
    } else {
        redirectToLogin();
    }
}

// Mock login toggle (for testing purposes)
// Uncomment to simulate login
// localStorage.setItem("loggedIn", "true");
