// Show the selected section and highlight the active tab
function showprofileSection(sectionId) {
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
function logout(event) {
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




//navbar page li redirect to profile page's respective div
document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    const section = params.get("section") || "personal-info"; // Default to 'personal-info'
    
    // Activate the corresponding tab
    document.querySelectorAll("ul li").forEach((li) => li.classList.remove("active"));
    const activeTab = document.getElementById(`${section}-tab`);
    if (activeTab) activeTab.classList.add("active");
    
    // Show the corresponding section
    document.querySelectorAll(".section").forEach((section) => {
        section.classList.remove("active");
    });
    const activeSection = document.getElementById(section);
    if (activeSection) activeSection.classList.add("active");
});
