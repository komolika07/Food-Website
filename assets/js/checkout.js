
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


document.getElementById('change-address-btn').addEventListener('click', function () {
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
document.addEventListener('change', function (event) {
    if (event.target.name === 'address') {
        // Hide all "Deliver Here" buttons
        document.querySelectorAll('.deliver-here-btn').forEach(btn => {
            btn.style.display = 'none';
        });

        // Show the corresponding "Deliver Here" button
        let selectedAddressId = event.target.getAttribute('data-address-id');
        let deliverHereButton = document.querySelector(`.deliver-here-btn[data-address-id="${selectedAddressId}"]`);
        if (deliverHereButton) {
            deliverHereButton.style.display = 'inline-block';
        }
    }
});


document.addEventListener('click', function (event) {
    if (event.target.classList.contains('deliver-here-btn')) {
        let selectedAddressId = event.target.getAttribute('data-address-id');

        fetch('../includes/set_default_address.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ 'address_id': selectedAddressId })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Address set as default!');
                    location.reload();
                } else {
                    alert('Failed to update address: ' + (data.error || 'Unknown error'));
                }
            });
    }
});



function showContinue(selectedOption) {
    // Hide all continue buttons
    document.querySelectorAll(".continue-btn").forEach(btn => {
        btn.classList.add("hidden");
    });

    // Show the continue button for the selected option
    document.getElementById("continue-" + selectedOption).classList.remove("hidden");
}

document.addEventListener("DOMContentLoaded", () => {
    document.querySelector("#continue-cod").addEventListener("click", function () {
        let selectedAddress = document.getElementById("default-address-id")?.value;
        let paymentMethod = document.querySelector("input[name='payment']:checked")?.value;
        let totalPrice = document.getElementById("total-price")?.value;
        let isCart = document.getElementById("isCart")?.value;
        let quantity = document.getElementById("quantity")?.value;
        let product_id = document.getElementById("product_id")?.value;

        if (!selectedAddress) {
            Swal.fire("Error!", "Please select a delivery address.", "error");
            return;
        }
        if (!paymentMethod) {
            Swal.fire("Error!", "Please select a payment method.", "error");
            return;
        }

        // Confirmation Popup
        Swal.fire({
            // title: "Confirm Order?",
            text: "Do you want to confirm your order?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Confirm!",
            cancelButtonText: "Cancel",
            customClass: {
                confirmButton: 'custom-confirm-btn primary-btn',
                cancelButton: 'custom-cancel-btn secondary-btn'
            }
        })
        .then((result) => {
            if (result.isConfirmed) {
                let bodyData = `payment_method=${paymentMethod}&address_id=${selectedAddress}&total_price=${totalPrice}&isCart=${isCart}`;
                if (isCart === "false") {
                    bodyData += `&product_id=${product_id}&quantity=${quantity}`;
                }

                fetch("../includes/confirm_order.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: bodyData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: "Success!",
                            text: "Order placed successfully!",
                            icon: "success",
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: 'custom-confirm-btn primary-btn',
                            }
                        }).then(() => {
                            window.location.href = `order_summary.php?order_id=${data.order_id}`;
                        });
                    } else {
                        Swal.fire("Error!", data.message || "Failed to place the order.", "error");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire("Error!", "Something went wrong. Please try again.", "error");
                });
            }
        });
    });
});
