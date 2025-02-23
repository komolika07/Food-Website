
document.addEventListener("DOMContentLoaded", () => {

    const addAddressBtn = document.getElementById("add-address-btn");

    if (addAddressBtn) {
        addAddressBtn.addEventListener("click", function () {

            const addressList = document.getElementById("address-list");

            // document.getElementById("address-form").style.display = "block"; 

            // Create a new address form
            const addressForm = document.createElement("div");
            addressForm.classList.add("address-form");
            addressForm.innerHTML = `
        <?php if (!$max_addresses_reached): ?>
            <form action="../includes/manageAddress.php" method="post">
                                    <div class="form-container">
                                    <input type="hidden" id="user-id" name="user_id" value="">
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" id="name" name="user-name" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">10-digit mobile number</label>
                                                <input type="tel" id="phone" name="phone" placeholder="">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="pincode">Pincode</label>
                                                <input type="text" id="pincode" name="zip" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="locality">Locality</label>
                                                <input type="text" id="locality" name="Locality" placeholder="">
                                            </div>
                                        </div>

                                        <div class="form-group" style="margin-bottom: 15px;">
                                            <label for="address">Address (Area and Street)</label>
                                            <textarea id="address" name="address_line" placeholder=""></textarea>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="city">City/District/Town</label>
                                                <input type="text" id="city" name="city" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="state">State</label>
                                                <input type="text" value="Maharashtra" disabled>
                                                 <input type="hidden" name="state" value="Maharashtra">
                                                
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="landmark">Landmark (Optional)</label>
                                                <input type="text" id="landmark" name="landmark" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="alt-phone">Alternate Phone (Optional)</label>
                                                <input type="tel" id="alt-phone" name="alt-phone" placeholder="">
                                            </div>
                                        </div>
                                   
                                        <div class="actions">
                                            <button type="submit" class="save-address-btn primary-btn">Save Address</button>
                                            <button type="button" class="remove-address-btn secondary-btn">Remove</button>
                                        </div>
                                    </div>

                                    <hr>
            </form>
        <?php endif; ?>

    `;

            // Append the form to the list
            addressList.appendChild(addressForm);

            const userId = this.getAttribute("data-user-id");
            // Log the user_id to check if it's correctly passed
            console.log("User ID:", userId);

            const userIdInput = document.getElementById("user-id");
            if (userIdInput) {
                userIdInput.value = userId;  // Dynamically set the hidden input's value
            }


            // Add event listener to remove button
            addressForm.querySelector(".remove-address-btn").addEventListener("click", function () {
                addressList.removeChild(addressForm);
            });
        });
    }
});





document.querySelectorAll('.delete-address').forEach(button => {
    button.addEventListener('click', function () {
        const addressId = this.getAttribute('data-id');

        // Ask for confirmation before deleting
        if (confirm("Are you sure you want to delete this address?")) {
            // Send AJAX request to delete address
            fetch('../includes/deleteAddress.php?id=' + addressId, {
                method: 'GET',
            }).then(response => response.json()) // Parse the JSON response
                .then(data => {
                    // Handle the response based on success or failure
                    if (data.success) {
                        // Show success message using showAlert function
                        showAlert(data.message, "success");

                        setTimeout(function () {
                            location.reload(); // Refresh the page after 5 seconds (adjust as needed)
                        }, 5000);
                    } else {
                        // Show error message using showAlert function
                        showAlert(data.message, "error");
                    }
                }).catch(error => {
                    // In case of network or other errors, show an error message
                    showAlert("An error occurred. Please try again later.", "error");
                });
        }
    });
});





document.addEventListener("DOMContentLoaded", () => {
    const editButtons = document.querySelectorAll(".edit-address");
    const editModal = document.getElementById("edit-form-modal");
    const editForm = document.getElementById("edit-address-form");
    const cancelEditBtn = document.getElementById("cancel-edit-btn");
    const body = document.querySelector('body');
    editButtons.forEach(button => {
        button.addEventListener("click", () => {
            const userName = button.dataset.userName;
            const phone = button.dataset.phone;
            const addressId = button.dataset.id;
            const addressLine = button.dataset.addressLine;
            const city = button.dataset.city;
            const zip = button.dataset.zip;
            const locality = button.dataset.locality;
            const landmark = button.dataset.landmark;
            const alt_phone = button.dataset.alt_phone;

            // Fill the form inputs
            document.getElementById("edit-user-name").value = userName;
            document.getElementById("edit-phone").value = phone;
            document.getElementById("edit-address-id").value = addressId;
            document.getElementById("edit-address-line").value = addressLine;
            document.getElementById("edit-city").value = city;
            document.getElementById("edit-zip").value = zip;
            document.getElementById("edit-locality").value=locality;
            document.getElementById("edit-landmark").value=landmark;
            document.getElementById("edit-alt-phone").value=alt_phone;

            // Show the modal
            editModal.classList.add("show");
            body.classList.add('no-scroll');
        });
    });

    // Close modal on cancel
    if (cancelEditBtn) {
        cancelEditBtn.addEventListener("click", () => {
            editModal.classList.remove("show");
            body.classList.remove('no-scroll');
        });
    }

});


//cancel -booking 

// document.addEventListener("DOMContentLoaded", () => {
//     const cancelButtons = document.querySelectorAll(".cancel-booking-btn");

//     cancelButtons.forEach((btn) => {
//         btn.addEventListener("click", (e) => {
//             e.preventDefault();

//             const bookingId = btn.dataset.bookingId; // Assuming you store booking_id in a data attribute
//             const formData = new FormData();
//             formData.append("booking_id", bookingId);

//             fetch("../includes/cancelBooking.php", {
//                 method: "POST",
//                 body: formData,
//             })
//                 .then((response) => response.json())
//                 .then((data) => {
//                     showAlert(data.message, data.type); // Assuming you have a showAlert function
//                     if (data.type === "success") {
//                         setTimeout(() => {
//                             window.location.href("../view/profile.php"); // Refresh the page after showing alert
//                         }, 5000); // Delay for 2 seconds
//                     }
//                 })
//                 .catch((error) => {
//                     console.error("Error:", error);
//                     showAlert("An error occurred. Please try again.", "error");
//                 });
//         });
//     });
// });


document.querySelectorAll('.cancel-btn').forEach(button => {
    button.addEventListener('click', function () {
        const BookingId = this.getAttribute('data-id');

        // Ask for confirmation before deleting
        if (confirm("Are you sure you want to cancel this booking?")) {
            // Send AJAX request to delete address
            fetch('../includes/cancelBooking.php?id=' + BookingId, {
                method: 'GET',
            }).then(response => response.json()) // Parse the JSON response
                .then(data => {
                    // Handle the response based on success or failure
                    if (data.success) {
                        // Show success message using showAlert function
                        showAlert(data.message, "success");

                        setTimeout(function () {
                            location.reload(); // Refresh the page after 5 seconds (adjust as needed)
                        }, 5000);
                    } else {
                        // Show error message using showAlert function
                        showAlert(data.message, "error");
                    }
                }).catch(error => {
                    // In case of network or other errors, show an error message
                    console.log(error);
                    showAlert("An error occurred. Please try again later.", "error");
                });
        }
    });
});
