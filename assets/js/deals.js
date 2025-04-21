document.addEventListener("DOMContentLoaded", function () {
    const timers = document.querySelectorAll(".deal-timer");

    function updateTimer() {
        timers.forEach(timer => {
            let expiryDate = new Date(timer.getAttribute("data-expiry")).getTime();
            let now = new Date().getTime();
            let difference = expiryDate - now;

            if (difference > 0) {
                let days = Math.floor(difference / (1000 * 60 * 60 * 24));
                let hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((difference % (1000 * 60)) / 1000);
                timer.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            } else {
                timer.innerHTML = "Expired";
            }
        });
    }

    updateTimer();
    setInterval(updateTimer, 1000);
});

const dealquickViewBtns = document.querySelectorAll('.deal-quick-view-btn');
const dealContainer = document.getElementById('deal-popup');
const dealclosePopupBtn = document.querySelector('.deal-close-popup');

// Popup content field
const dealImage = document.getElementById('deal-main-image');
const dealTitle = document.getElementById('deal-title');
const dealPrice = document.getElementById('popup-deal-price');
const dealRating = document.getElementById("deal-rating");
const dealCategory = document.getElementById("deal-category");
const dealOriginalPrice = document.getElementById('popup-deal-original-price');
const dealDescription = document.getElementById('deal-description');
const dealDiscount = document.getElementById('popup-deal-discount');
const dealaddToCartButton = document.querySelector('.deal-add-to-cart'); // Add To Cart button in popup
const dealbuyNowButton = document.querySelector('.buy-now-btn'); // Buy Now button in popup
// Event listener for Quick View buttons
dealquickViewBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
        const dealcard = btn.closest('.deal-card'); // Get the respective card

        // Extract details from the card
        const productId = dealcard.getAttribute('data-id');
        const imagePath = dealcard.getAttribute('data-image');
        const title = dealcard.getAttribute('data-name');
        const price = dealcard.getAttribute('data-price');
        const originalPrice = dealcard.getAttribute('data-original-price');
        const discount = dealcard.getAttribute('data-discount');
        const rating = dealcard.getAttribute("data-rating");
        const description = dealcard.getAttribute('data-description');
        const itemsArray = JSON.parse(dealcard.getAttribute('data-items'));


        // Populate popup content
        dealImage.src = imagePath;
        dealTitle.textContent = itemsArray;
        dealPrice.textContent = "₹" + price;

        dealDescription.textContent = description;
        dealRating.textContent = rating;
        dealCategory.textContent = title;


        if (discount > 0) {
            dealDiscount.style.display = 'inline-block';
            dealOriginalPrice.textContent = "₹" + originalPrice;
            dealDiscount.textContent = discount + "% OFF";
        }
        else {
            // dealOriginalPrice.textContent = "₹" + originalPrice;
            dealOriginalPrice.textContent = '';
            dealDiscount.style.display = 'none';
        }
        // Update Add To Cart button with the product ID
        console.log("Product ID: ", productId);
        dealaddToCartButton.setAttribute('data-id', productId);
        dealbuyNowButton.setAttribute('data-id', productId);

        // **Disable buttons if the product is out of stock**
        // if (status.toLowerCase() === "out-of-stock") {
        //     addToCartButton.setAttribute("disabled", "disabled");
        //     buyNowButton.setAttribute("disabled", "disabled");
        //     popupStatus.textContent = "Out of Stock";
        // } else {
        //     addToCartButton.removeAttribute("disabled");
        //     buyNowButton.removeAttribute("disabled");
        //     popupStatus.textContent = '';
        // }

        // Show the popup
        dealContainer.style.display = 'flex';
        document.body.classList.add('no-scroll');
    });
});

if (dealclosePopupBtn) {
    // Event listener to close the popup
    dealclosePopupBtn.addEventListener('click', () => {
        dealContainer.style.display = 'none';
        document.body.classList.remove('no-scroll');
    });
}



// Add To Cart functionality
// Select the "Add to Cart" button in the popu

// Event listener for the "Add to Cart" button in the quick view popup

// document.addEventListener("DOMContentLoaded", () => {
//     // Quantity buttons
//     const decrementBtn = document.querySelector(".decrement-btn");
//     const incrementBtn = document.querySelector(".increment-btn");
//     const quantityInput = document.querySelector(".quantity-input");

//     // Add to Cart button
//     // const addToCartBtn = document.querySelector(".popup-add-to-cart");

//     // Update quantity on increment/decrement
//     decrementBtn.addEventListener("click", () => {
//         let quantity = parseInt(quantityInput.value);
//         if (quantity > 1) {
//             quantity--;
//             quantityInput.value = quantity;
//         }
//     });

//     incrementBtn.addEventListener("click", () => {
//         let quantity = parseInt(quantityInput.value);
//         quantity++;
//         quantityInput.value = quantity;
//     });

//     if (addToCartButton) {
//         addToCartButton.addEventListener('click', () => {
//             const productId = addToCartButton.getAttribute('data-id'); // Get the product ID from the data-id attribute
//             const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
//             // Make sure the productId exists
//             if (productId) {
//                 // Send an AJAX request to add the product to the cart
//                 fetch('../includes/layout/add_to_cart.php', {
//                     method: 'POST',
//                     headers: {
//                         'Content-Type': 'application/x-www-form-urlencoded'
//                     },
//                     body: `id=${productId}&quantity=${quantity}`

//                 })
//                     .then(response => response.json())
//                     .then(data => {
//                         if (data.success) {
//                             // Handle success (e.g., show a success message or update the cart UI)
//                             showAlert(data.message, "success"); // For now, we show the success message using an alert.
//                             popupContainer.style.display = 'none'; // Close the popup after adding to the cart
//                             document.body.classList.remove("no-scroll");
//                         } else {
//                             //Handle failure (e.g., show an error message)
//                             showAlert(data.message, "error");
//                         }
//                     })
//                     .catch(error => {
//                         console.error('Error:', error);
//                         showAlert('Something went wrong. Please try again.', "error");
//                     });
//             } else {
//                 showAlert('Product ID is missing.', "error");
//             }
//         });
//     }


// })