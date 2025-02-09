
function showSection(sectionId) {
    // Hide all sections
    const menu_card_sections = document.querySelectorAll('.menu-display-section');
    menu_card_sections.forEach(menu_card_section => menu_card_section.classList.remove('active'));

    // Remove active class from all tabs
    const tabs = document.querySelectorAll('.view-menu-container ul li');
    tabs.forEach(tab => tab.classList.remove('active'));

    // Show the selected section
    document.getElementById(sectionId).classList.add('active');

    // Highlight the active tab
    const activeTab = document.getElementById(`${sectionId}-tab`);
    if (activeTab) {
        activeTab.classList.add('active');
    }
}




function showCardSection(id) {
    // Split the ID to get the category and meal option (e.g., "starter-veg")
    const [category, option] = id.split('-');

    // Hide all sections in the current category
    document.querySelectorAll(`#${category}-section .menu`).forEach(section => {
        section.classList.remove('active');
    });

    // Remove active class from all tabs in the current category
    document.querySelectorAll(`#${category}-section .meals-options ul li`).forEach(tab => {
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


// Function to open the edit form and populate it
function openEditForm(button) {
    // Get data attributes from the clicked button
    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const category = button.getAttribute('data-category');
    const price = button.getAttribute('data-price');
    const status = button.getAttribute('data-status');
    const discount = button.getAttribute('data-discount');
    const description = button.getAttribute('data-description');
    const image = button.getAttribute('data-image');
    const mealOp = button.getAttribute('data-meal-op');
    const discountedPrice = button.getAttribute('data-discounted-price');
    const rating = button.getAttribute('data-rating');


    // Populate the form fields
    document.getElementById('edit-product-id').value = id;
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-category').value = category;
    document.getElementById('edit-price').value = price;
    document.getElementById('edit-status').value = status;
    document.getElementById('edit-discount').value = discount;
    document.getElementById('edit-description').value = description;
    document.getElementById('edit-meal-op').value = mealOp;
    document.getElementById('edit-discounted-price').value = discountedPrice;
    document.getElementById('edit-rating').value = rating;
    document.getElementById('edit-image').src = `../${image}`;
    // Assuming you are populating the form with the existing values using JavaScript
    document.getElementById("edit-image-path").value = image;

    // Display the popup form
    document.querySelector('#edit-form').classList.add('active');
    document.querySelector('.main-content').classList.add('popup-active');
}

// Function to close the edit form
function closeEditForm() {
    document.querySelector('#edit-form').classList.remove('active');
    document.querySelector('.main-content').classList.remove('popup-active');
}

// Attach the close function to the cancel button
document.getElementById('cancel-btn').addEventListener('click', closeEditForm);







function confirmDelete(id) {
    console.log("ID to delete:", id); // Debug the ID being passed

    if (confirm("Are you sure you want to delete this item?")) {
        fetch(`../includes/delete-item.php?id=${id}`, {
            method: "GET",
        })
            .then((response) => response.text())
            .then((data) => {
                console.log("Response from server:", data); // Log the server response
                if (data.includes("success")) {
                    alert("Item deleted successfully.");
                    // Optionally, remove the row from the table
                    const row = document.querySelector(`button[onclick='confirmDelete(${id})']`).closest("tr");
                    row.remove();
                } else {
                    alert("Failed to delete item: " + data);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("An error occurred. Please try again.");
            });
    } else {
        console.log("Deletion canceled.");
    }
}
