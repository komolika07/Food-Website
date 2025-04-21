document.addEventListener("DOMContentLoaded", function () {
    showOrders();
});

// Fetch and display orders
function showOrders() {
    let status = document.getElementById("orderStatusDropdown").value;
    // let row = document.querySelector('.order-row');
    document.querySelectorAll(".orders-container").forEach(div => {
        div.classList.remove("active");
    });

    let selectedDiv = document.getElementById(status);
    selectedDiv.classList.add("active");
    // row.classList.add("back-color");

    fetch(`../includes/fetch_order.php?status=${status}`)
        .then(response => response.text())
        .then(data => {
            selectedDiv.innerHTML = data;
            attachRowClickEvent(); // Attach event listeners after loading orders
        })
        .catch(error => console.error("Error fetching orders:", error));
}

// Attach event listeners for order rows
function toggleDetails(button) {
    let orderRow = button.closest('.order-row'); // Find the parent order row
    let detailsDiv = orderRow.querySelector('.order-details');

    if (detailsDiv.style.display === "none") {
        detailsDiv.style.display = "block";
        button.innerHTML = "<i class='fa-solid fa-eye'></i>"; // Change arrow up when open
        orderRow.classList.add("back-color");
    } else {
        detailsDiv.style.display = "none";
        button.innerHTML = "<i class='fa-solid fa-eye'></i>"; // Change arrow down when closed
        orderRow.classList.remove("back-color"); 
    }
}

function assignDeliveryBoy(orderId, deliveryBoyId) {
    fetch('../includes/assigning_delivery_boy.php', {  // Ensure correct path
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ order_id: orderId, delivery_boy_id: deliveryBoyId })
    })
    .then(response => response.json())  // Ensure JSON response
    .then(data => {
        alert(data.message);
        if (data.success) showOrders(); // Reload orders after update
    })
    .catch(error => console.error('Error assigning delivery boy:', error));
}




// Update order status
function updateStatus(orderId, newStatus) {
    fetch('../includes/update_status.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ order_id: orderId, status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) showOrders(); // Reload orders after update
    })
    .catch(error => alert('Error updating status: ' + error));
}

// Assign delivery boy


