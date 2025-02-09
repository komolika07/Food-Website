function showBookingSection(sectionId) {
    // Hide all sections
    const menu_booking_sections = document.querySelectorAll('.display-section');
    menu_booking_sections.forEach(menu_book_section => menu_book_section.classList.remove('active'));

    // Remove active class from all tabs
    const tabs = document.querySelectorAll('.view-Booking-container ul li');
    tabs.forEach(tab => tab.classList.remove('active'));

    // Show the selected section
    document.getElementById(sectionId).classList.add('active');

    // Highlight the active tab
    const activeBookTab = document.getElementById(`${sectionId}-tab`);
    if (activeBookTab) {
        activeBookTab.classList.add('active');
    }
}


function showAlert(message, type) {
    // Create the custom alert container if it doesn't exist
    let alertContainer = document.getElementById("custom-alert");
    if (!alertContainer) {
        alertContainer = document.createElement("div");
        alertContainer.id = "custom-alert";
        document.body.appendChild(alertContainer);
    }
  
    // Create the alert element
    const alert = document.createElement("div");
    alert.classList.add("alert", type); // Add type (success, error) for styling
    alert.innerHTML = `
        <span>${message}</span>
        <span class="close-btn">&times;</span>
    `;
  
    // Append the alert to the container
    alertContainer.appendChild(alert);
  
    // Add event listener for the close button
    alert.querySelector(".close-btn").addEventListener("click", () => {
        alert.style.animation = "slideOutToRight 0.5s ease";
        setTimeout(() => alert.remove(), 500); // Remove after animation ends
    });
  
    // Auto-remove the alert after 5 seconds
    setTimeout(() => {
        alert.style.animation = "slideOutToRight 0.5s ease";
        setTimeout(() => alert.remove(), 500); // Remove after animation ends
    }, 5000);
  }
  