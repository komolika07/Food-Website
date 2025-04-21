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
function confirmLogout() {
    Swal.fire({
        title: "Are you sure?",
        text: "You will be logged out of your account.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Logout",
        cancelButtonText: "Cancel",
        customClass: {
            confirmButton: 'custom-confirm-btn primary-btn',
            cancelButton: 'custom-cancel-btn secondary-btn'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "../includes/logout.php";
        }
    });
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



document.addEventListener("DOMContentLoaded", function () {
    fetch("../includes/fetch_orders.php") // Fetch orders from PHP
        .then(response => response.text())
        .then(data => {
            document.querySelector(".order-display-container").innerHTML = data;
        })
        .catch(error => console.error("Error fetching orders:", error));
});