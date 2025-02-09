




//to display the navbar when fa-bar icon is clicked
let navbar = document.querySelector('.navbar-items');
let menuIcon = document.querySelector('#menu-icon');
menuIcon.addEventListener('click', () => {
    navbar.classList.toggle('active');


});

//to hide navbar when individual item of navbar is clicked
let menu_items = document.querySelectorAll('.navbar-items a');

menu_items.forEach((item) => {
    item.addEventListener('click', () => {
        navbar.classList.toggle('active');
    })
});



const categorydropdownButton = document.querySelector('.category-dropdown button');
const dropdownMenu = document.querySelector('.category-drop');

categorydropdownButton.addEventListener('click', function (event) {
    event.stopPropagation(); // Prevent click from propagating to the document
    const isVisible = dropdownMenu.style.display === 'inline-block';
    dropdownMenu.style.display = isVisible ? 'none' : 'inline-block';
});

// Close dropdown when clicking outside
document.addEventListener('click', function () {
    dropdownMenu.style.display = 'none';
});





//slider 

let currentSlide = 0; // Initialize the currentSlide variable

function moveSlide(direction) {
    const slides = document.querySelectorAll('.slide');
    const slidesContainer = document.querySelector('.slides');
    const totalSlides = slides.length;

    // Update the current slide index
    currentSlide = (currentSlide + direction + totalSlides) % totalSlides;

    // Move the slides container to show the correct slide
    if(slidesContainer){
        slidesContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
    }
    

    // Remove and re-add the animation classes to restart the animations
    slides.forEach((slide, index) => {
        const content = slide.querySelector('.content');
        const sliderImage = slide.querySelector('.slider-image');
        const sliderMsgBox = slide.querySelector('.msg');

        if (index === currentSlide) {
            // Ensure that content animations only start when the slide is active
            if (content) {
                content.classList.remove('animate');
                void content.offsetWidth; // Trigger reflow to restart animation
                content.classList.add('animate');
            }
            if (sliderImage) {
                sliderImage.classList.remove('animate');
                void sliderImage.offsetWidth; // Trigger reflow to restart animation
                sliderImage.classList.add('animate');
            }
            if (sliderMsgBox) {
                sliderMsgBox.classList.remove('animate');
                void sliderMsgBox.offsetWidth; // Trigger reflow to restart animation
                sliderMsgBox.classList.add('animate');
            }
        } else {
            // Remove the animate class from non-active slides
            if (content) content.classList.remove('animate');
            if (sliderImage) sliderImage.classList.remove('animate');
            if (sliderMsgBox) sliderMsgBox.classList.remove('animate');
        }
    });
}

// Initially add the 'animate' class to the first slide's content and image if they exist
const firstSlide = document.querySelector('.slide');
if (firstSlide) {
    const firstContent = firstSlide.querySelector('.content');
    const firstSliderImage = firstSlide.querySelector('.slider-image');
    const firstMsgBox = firstSlide.querySelector('.msg');
    if (firstContent) firstContent.classList.add('animate');
    if (firstSliderImage) firstSliderImage.classList.add('animate');
    if (firstMsgBox) firstMsgBox.classList.add('animate');
}

// Automatically move the slide every 10 seconds (optional)
setInterval(() => {
    moveSlide(1);
}, 10000);





// category section

function showhomeSection(sectionId) {
    // Hide all sections
    const sections = document.querySelectorAll('.home-category-section');
    sections.forEach(section => section.classList.remove('active'));

    // Remove active class from all tabs
    const menuTabs = document.querySelectorAll('.menu-category li');
    menuTabs.forEach(tab => tab.classList.remove("active"));


    // Show the selected section
    const homesection = document.getElementById(sectionId);
    if (homesection) {
        homesection.classList.add('active');
    }

    // Highlight the active tab
    const activehomeTab = document.getElementById(`${sectionId}-tab`);
    if (activehomeTab) {
        activehomeTab.classList.add('active');
    }
}



// Get the popup and the close button



const quickViewBtns = document.querySelectorAll('.quick-view-btn');
const popupContainer = document.getElementById('quickview-popup');
const closePopupBtn = document.querySelector('.close-popup');

// Popup content fields
const popupImage = document.getElementById('popup-main-image');
const popupTitle = document.getElementById('popup-title');
const popupPrice = document.getElementById('popup-price');
const popupRating = document.getElementById("popup-rating");
const popupCategory = document.getElementById("popup-category");
const popupOriginalPrice = document.getElementById('popup-original-price');
const popupDescription = document.getElementById('popup-description');
const addToCartButton = document.querySelector('.popup-add-to-cart'); // Add To Cart button in popup
// const quantityInput = document.querySelector('.quantity-input'); // Quantity input field

// Event listener for Quick View buttons
quickViewBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
        const card = btn.closest('.card'); // Get the respective card

        // Extract details from the card
        const productId = card.getAttribute('data-id');
        const imagePath = card.getAttribute('data-image');
        const title = card.getAttribute('data-name');
        const price = card.getAttribute('data-price');
        const originalPrice = card.getAttribute('data-original-price');
        const rating = card.getAttribute("data-rating");
        const description = card.getAttribute('data-description');
        const category = card.getAttribute('data-category');

        // Populate popup content
        popupImage.src = imagePath;
        popupTitle.textContent = title;
        popupPrice.textContent = price;
        popupOriginalPrice.textContent = originalPrice;
        popupDescription.textContent = description;
        popupRating.textContent = rating;
        popupCategory.textContent = category;

        // Update Add To Cart button with the product ID
        console.log("Product ID: ", productId);
        addToCartButton.setAttribute('data-id', productId);

        // Add this to verify the ID
        // addToCartPopupBtn.setAttribute('data-id', productId);

        // Show the popup
        popupContainer.style.display = 'flex';
        document.body.classList.add('no-scroll');
    });
});

if (closePopupBtn) {
    // Event listener to close the popup
    closePopupBtn.addEventListener('click', () => {
        popupContainer.style.display = 'none';
        document.body.classList.remove('no-scroll');
    });

}


// Add To Cart functionality
// Select the "Add to Cart" button in the popu

// Event listener for the "Add to Cart" button in the quick view popup

document.addEventListener("DOMContentLoaded", () => {
    // Quantity buttons
    const decrementBtn = document.querySelector(".decrement-btn");
    const incrementBtn = document.querySelector(".increment-btn");
    const quantityInput = document.querySelector(".quantity-input");

    // Add to Cart button
    // const addToCartBtn = document.querySelector(".popup-add-to-cart");

    // Update quantity on increment/decrement
    decrementBtn.addEventListener("click", () => {
        let quantity = parseInt(quantityInput.value);
        if (quantity > 1) {
            quantity--;
            quantityInput.value = quantity;
        }
    });

    incrementBtn.addEventListener("click", () => {
        let quantity = parseInt(quantityInput.value);
        quantity++;
        quantityInput.value = quantity;
    });

    if (addToCartButton) {
        addToCartButton.addEventListener('click', () => {
            const productId = addToCartButton.getAttribute('data-id'); // Get the product ID from the data-id attribute
            const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
            // Make sure the productId exists
            if (productId) {
                // Send an AJAX request to add the product to the cart
                fetch('../includes/layout/add_to_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${productId}&quantity=${quantity}`

                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Handle success (e.g., show a success message or update the cart UI)
                            showAlert(data.message, "success"); // For now, we show the success message using an alert.
                            popupContainer.style.display = 'none'; // Close the popup after adding to the cart
                            document.body.classList.remove("no-scroll");
                        } else {
                            //Handle failure (e.g., show an error message)
                            showAlert(data.message, "error");
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('Something went wrong. Please try again.', "error");
                    });
            } else {
                showAlert('Product ID is missing.', "error");
            }
        });
    }


})


// addToCartButton.addEventListener('click', () => {
//   const productId = addToCartButton.getAttribute('data-id');
//   const quantity = quantityInput ? parseInt(quantityInput.value) : 1;

//   fetch('/includes/layout/add_to_cart.php', {
//     method: 'POST',
//     headers: {
//       'Content-Type': 'application/x-www-form-urlencoded',
//     },
//     body: new URLSearchParams({
//       id: productId,
//       quantity: quantity,
//     }),
//   })
//     .then((response) => response.json())
//     .then((data) => {
//       alert(data.message); // Display success/error message
//       if (data.success) {
//         console.log('Product successfully added to cart.');
//         // Optionally update the cart icon or close the popup
//       }
//     })
//     .catch((error) => console.error('Error adding to cart:', error));
// });

// // Optional: Close popup when clicking outside the content
// popupContainer.addEventListener('click', (event) => {
//   if (event.target === popupContainer) {
//     popupContainer.style.display = 'none';
//     document.body.classList.remove('no-scroll');
//   }
// });







//quickview popup quantity add logic

// document.querySelectorAll('.quantity-add').forEach((container) => {
//   const decrementBtn = container.querySelector('.decrement-btn');
//   const incrementBtn = container.querySelector('.increment-btn');
//   const quantityInput = container.querySelector('.quantity-input');

//   //Decrease quantity
//   decrementBtn.addEventListener('click', () => {
//     const currentValue = parseInt(quantityInput.value, 10);
//     if (currentValue > 1) {
//       quantityInput.value = currentValue - 1;
//     }
//   });

//   //Increase quantity
//   incrementBtn.addEventListener('click', () => {
//     const currentValue = parseInt(quantityInput.value, 10);
//     quantityInput.value = currentValue + 1;
//   });

//   //Restrict input to numbers greater than or equal to 1
//   quantityInput.addEventListener('input', () => {
//     if (quantityInput.value < 1) {
//       quantityInput.value = 1;
//     }
//   });
// });








const carousel = document.querySelector('.feedback-carousel');
const prevBtn = document.querySelector('.prev-btn');
const nextBtn = document.querySelector('.next-btn');

let currentIndex = 0;
if (prevBtn) {
    prevBtn.addEventListener('click', () => {
        currentIndex = (currentIndex === 0) ? carousel.children.length - 1 : currentIndex - 1;
        updateCarousel();
    });
}

if (nextBtn) {
    nextBtn.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % carousel.children.length;
        updateCarousel();
    });
}


function updateCarousel() {
    const cardWidth = carousel.parentElement.offsetWidth; // Use the container's width
    carousel.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
}





