// Show the selected section and highlight the active tab
function showSection(sectionId) {
    // Hide all sections
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => section.classList.remove('active'));

    // Remove active class from all tabs
    const tabs = document.querySelectorAll('.sidebar ul li');
    tabs.forEach(tab => tab.classList.remove('active'));

    // Show the selected section
    document.getElementById(sectionId).classList.add('active');

    // Highlight the active tab
    const activeTab = document.getElementById(`${sectionId}-tab`);
    if (activeTab) {
        activeTab.classList.add('active');
    }
}

// Logout function
function logout() {
    const confirmation = confirm("Do you want to log out?");
    if (!confirmation) {
        event.preventDefault(); // Stop the link from redirecting
    }
    else{
        window.location.href = "loginForm.php"; // Replace with your login page

    }
    // alert('You have been logged out.');
    // Redirect to login page or clear session
}
