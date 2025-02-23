function showCardSection(id) {
    // Split the ID to get the category and meal option (e.g., "starter-veg")
    const [category, mealOp] = id.split('-');

    // Hide all sections in the current category
    document.querySelectorAll(`#${category}-section .starter-menu`).forEach(section => {
        section.classList.remove('active');
    });

    // Remove active class from all tabs in the current category
    document.querySelectorAll(`#${category}-section .V_NV_op ul li`).forEach(tab => {
        tab.classList.remove('active');
    });

    // Show the selected section
    document.getElementById(id).classList.add('active');

    // Highlight the selected tab
    document.getElementById(`${id}-tab`).classList.add('active');

    // Ensure that when switching categories, the Veg tab is active by default
    const categorySection = document.getElementById(`${category}-section`);
    if (categorySection) {
        const vegTabId = `${category}-veg-tab`;
        const vegSectionId = `${category}-veg`;

        // Set Veg as default if no Non-Veg or other tab is selected
        if (!document.querySelector(`#${category}-section .starter-menu.active`)) {
            document.getElementById(vegTabId).classList.add('active');
            document.getElementById(vegSectionId).classList.add('active');
        }
    }
}





function showSection(sectionId) {
    // Hide all sections
    const menu_card_sections = document.querySelectorAll('.menu-card-section');
    menu_card_sections.forEach(menu_card_section => menu_card_section.classList.remove('active'));

    // Remove active class from all tabs
    const tabs = document.querySelectorAll('.menu-sidebar ul li');
    tabs.forEach(tab => tab.classList.remove('active'));

    // Show the selected section
    const selectedSection = document.getElementById(sectionId);
    if(selectedSection){
        selectedSection.classList.add('active');
    }
   

    // Highlight the active tab
    const activeTab = document.getElementById(`${sectionId}-tab`);
    if (activeTab) {
        activeTab.classList.add('active');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const category = params.get('category') || 'starter'; // Default to 'starter'
    showSection(`${category}-section`);
});




document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".buy-now-btn").addEventListener("click", function () {
        let productId = this.getAttribute("data-id");
        let quantity = document.querySelector(".quantity-input").value;

        // Redirect to checkout with Buy Now parameters
        window.location.href = `checkout.php?buy_now=1&product_id=${productId}&quantity=${quantity}`;
    });
});



