
document.getElementById('change-btn').addEventListener('click', function () {
    // Hide the original section and show the change section
    document.getElementById('login-details').style.display = 'block';
    // document.getElementById('change-details').style.display = 'none';
    document.getElementById('user-name-phone').style.display = 'none'; // Hide name and phone display
});

document.getElementById('continue-checkout-btn').addEventListener('click', function () {
    // Revert back to the original section with the name and phone visible
    document.getElementById('login-details').style.display = 'none';
    // document.getElementById('change-details').style.display = 'none';
    document.getElementById('user-name-phone').style.display = 'inline'; // Show name and phone again
});





document.getElementById('change-address-btn').addEventListener('click', function() {
    const addressList = document.getElementById('address-list-section');
    const defaultAddressDisplay = document.getElementById('default-address-display');
    if (addressList.style.display === 'none') {
        addressList.style.display = 'block'; 
        defaultAddressDisplay.style.display = 'none';  // Hide the default address section
         // Show address list
    } else {
        addressList.style.display = 'none';   // Hide address list
        defaultAddressDisplay.style.display = 'block';  // Show the default address section
    }
});

// Show the "Deliver Here" button when an address is selected
document.querySelectorAll('input[name="address"]').forEach(radio => {
    radio.addEventListener('change', function() {
        // Hide all "Deliver Here" buttons first
        document.querySelectorAll('.deliver-here-btn').forEach(btn => {
            btn.style.display = 'none';
        });

        // Show the corresponding "Deliver Here" button
        const selectedAddressId = this.getAttribute('data-address-id');
        const deliverHereButton = document.querySelector(`.deliver-here-btn[data-address-id="${selectedAddressId}"]`);
        if (deliverHereButton) {
            deliverHereButton.style.display = 'inline-block';
        }
    });
});


// Handle "Deliver Here" button click
document.querySelectorAll('.deliver-here-btn').forEach(button => {
    button.addEventListener('click', function() {
        let selectedAddressId = this.getAttribute('data-address-id');
        
        // Send a request to mark this address as the default (via AJAX or form submission)
        fetch('../includes/set_default_address.php', {
            method: 'POST',
            body: new URLSearchParams({
                'address_id': selectedAddressId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Address set as default!');
                // Reload the page to reflect the changes
                location.reload();
            } else {
                alert('Failed to update default address.');
            }
        });
    });
});
