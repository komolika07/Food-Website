// document.addEventListener("DOMContentLoaded", () => {
//     const wishlistButtons = document.querySelectorAll(".wishlist-btn");

//     wishlistButtons.forEach((btn) => {
//         btn.addEventListener("click", () => {
//             const card = btn.closest(".card");
//             const productId = card.getAttribute("data-id"); // Get product ID from the card

//             // Send AJAX request to add product to wishlist
//             fetch("../includes/add-to-wishlist.php", {
//                 method: "POST",
//                 headers: {
//                     "Content-Type": "application/x-www-form-urlencoded",
//                 },
//                 body: `id=${productId}`, // Pass the product ID
//             })
//                 .then((response) => response.json())
//                 .then((data) => {
//                     // Use your custom showAlert function
//                     showAlert(data.message, data.success ? "success" : "error");
//                 })
//                 .catch((error) => {
//                     console.error("Error:", error);
//                     showAlert("An error occurred. Please try again.", "error");
//                 });
//         });
//     });
// });

// document.querySelectorAll(".wishlist-btn").forEach((btn) => {
//     btn.addEventListener("click", () => {
//         const productId = btn.getAttribute("data-id"); // Ensure it updates every click
//         const productType = btn.getAttribute("data-type"); // menu_item or deal

//         console.log("Adding to Wishlist:", { productId, productType }); // Debugging

//         fetch("../includes/add-to-wishlist.php", {
//             method: "POST",
//             headers: {
//                 "Content-Type": "application/x-www-form-urlencoded",
//             },
//             body: `id=${productId}&type=${productType}`
//         })
//         .then(response => response.json())
//         .then(data => {
//             console.log("Wishlist Response:", data); // Debugging log
//             showAlert(data.message,data.success? 'success' : 'error');
//         })
//         .catch(error => {
//             console.error("Wishlist Error:", error);
//             showAlert("An error occurred. Please try again.", "error");
//         });
//     });
// });


document.addEventListener("DOMContentLoaded", () => {
    // Select all wishlist buttons (both menu items & deals)
    const wishlistButtons = document.querySelectorAll(".wishlist-btn");
    wishlistButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const card = btn.closest(".menu-card, .deal-card"); // Detect menu or deal card
            const productId = card.getAttribute("data-id");
            const productType = card.getAttribute("data-type");
            // const DealtotalOriginalPrice = card.getAttribute("data-original-price");
            addToWishlist(productId, productType);
        });
    });

    function addToWishlist(productId, productType,DealtotalOriginalPrice) {
        fetch("../includes/add-to-wishlist.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${productId}&type=${productType}`,
        })
        .then((response) => response.json())
        .then((data) => {
            // alert(data.message);
            showAlert(data.message,data.success? "success" : "error");
        })
        .catch((error) => {
            console.error("Error:", error);
            showAlert("An error occurred. Please try again.", "error");
        });
    }

    // Select all Add-to-Cart buttons (both menu items & deals)
    const cartButtons = document.querySelectorAll(".add-to-cart");
    cartButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const card = btn.closest(".menu-card, .deal-card");
            const productId = card.getAttribute("data-id");
            const productType = card.getAttribute("data-type");
           
            addToCart(productId, productType);
        });
    });

    function addToCart(productId, productType) {
        fetch("../includes/add-to-cart.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${productId}&type=${productType}&quantity=1`,
        })
        .then((response) => response.json())
        .then((data) => {
            showAlert(data.message);
        })
        .catch((error) => {
            console.error("Error:", error);
        });
    }
});


document.addEventListener("DOMContentLoaded", () => {
    const wishlistContainer = document.getElementById("wishlist-table-body"); // Ensure there's a <tbody> with this ID in your table

    // Fetch wishlist items from the server
    fetch("../includes/fetch_wishlist.php")
        .then((response) => response.text()) // Fetch as text for debugging
        .then((text) => {
            try {
                return JSON.parse(text);
            } catch (error) {
                console.error("Wishlist JSON Parse Error:", error, text);
                throw new Error("Invalid JSON response from server");
            }
        })
        .then((data) => {
            console.log("Wishlist Fetch Response:", data);

            if (!data.success) {
                console.error("Fetch Wishlist Error:", data.message);
                wishlistContainer.innerHTML = `<tr><td colspan="5">${data.message}</td></tr>`;
                return;
            }

            const items = data.data || []; // Fallback to empty array if undefined
            console.log("Fetched Items:", items);

            if (items.length === 0) {
                wishlistContainer.innerHTML = "<tr><td colspan='5'>Your wishlist is empty.</td></tr>";
                return;
            }

            wishlistContainer.innerHTML = ""; // Clear previous content

            items.forEach((item) => {
                // Handle missing or undefined properties
                const productId = item.product_id || "";
                const name = item.name || "Unknown Item";
                const imagePath = item.image_path ? `../admin/${item.image_path}` : "../assets/default-image.png";
                const price = item.price ? `<s>₹${item.price}</s>` : "N/A";
                const originalPrice = item.discounted_price ? `₹${item.discounted_price}` : "";
                const availability = (item.status && item.status.toLowerCase() === "out-of-stock") ? "Out of stock" : "In stock";
                const isOutOfStock = availability === "Out of stock";

                // Create table row
                const row = document.createElement("tr");
                row.classList.add("wishlist-item")
                row.innerHTML = `
                    <td class="flex">
                        <img src="${imagePath}" alt="${name}" class="wishlist-img">
                        ${name}
                    </td>
                    <td>${price} ${originalPrice}</td>
                    <td>${availability}</td>
                    <td>
                        <button class="add-to-cart primary-btn ${isOutOfStock ? 'disabled' : ''}" 
                                data-id='${productId}' ${isOutOfStock ? 'disabled' : ''} 
                                data-type="${item.type}">
                            Add To Cart
                        </button>
                    </td>
                    <td>
                        <button class="remove-btn" data-id="${productId}" data-type="${item.type}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                `;

                wishlistContainer.appendChild(row);
            });

            attachWishlistActions(); // Attach event listeners
        })
        .catch((error) => {
            console.error("Error fetching wishlist:", error);
            wishlistContainer.innerHTML = "<tr><td colspan='5'>Failed to load your wishlist. Please try again later.</td></tr>";
        });



    // Function to attach event listeners for wishlist actions
    function attachWishlistActions() {
        // Remove from wishlist
        document.querySelectorAll(".remove-btn").forEach((btn) => {
            btn.addEventListener("click", () => {
                const productId = btn.getAttribute("data-id");
                const productType = btn.getAttribute("data-type");
                if (confirm("Are you sure you want to remove this item from wishlist?")) {
                    fetch("../includes/remove_from_wishlist.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                        },
                        body: `id=${productId}&type=${productType}`
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        showAlert(data.message, data.success ? "success" : "error");

                        if (data.success) {
                            // Remove the item from the DOM
                            btn.closest(".wishlist-item").remove();

                            // Show empty message if no items remain
                            if (document.querySelectorAll(".wishlist-item").length === 0) {
                                wishlistContainer.innerHTML = "<p>Your wishlist is empty.</p>";
                            }
                        }
                    })
                    .catch((error) => {
                        console.error("Error removing from wishlist:", error);
                        showAlert("Failed to remove item from wishlist. Please try again.", "error");
                    });
                }
            });
        });

        // Add to Cart
        document.querySelectorAll(".add-to-cart").forEach((btn) => {
            btn.addEventListener("click", () => {
                const productId = btn.getAttribute("data-id");

                fetch("../includes/Layout/add_to_cart.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: `id=${productId}&quantity=1`
                })
                .then((response) => response.json())
                .then((data) => {
                    showAlert(data.message, data.success ? "success" : "error");
                })
                .catch((error) => {
                    // console.error("Error adding to cart:", error);
                    showAlert("Failed to add item to cart. Please try again.", "error");
                });
            });
        });
    }
});











// document.addEventListener("DOMContentLoaded", () => {
//     const wishlistContainer = document.getElementById("wishlist-container");
//     // const table = document.createElement('table');
//     // Fetch wishlist items from the server
//     fetch("../includes/fetch_wishlist.php")
//         .then((response) => response.json())
//         .then((data) => {
//             console.log("Wishlist Fetch Response:", data); // Debugging
//             if (data.success) {
//                 const items = data.data;
//                 console.log("Fetched Items:", items);

//                 if (items.length === 0) {
//                     wishlistContainer.innerHTML = "<p>Your wishlist is empty.</p>";
//                 } else {
//                     wishlistContainer.innerHTML = "";
//                     items.forEach((item) => {
//                         const wishlistDiv = document.createElement("div");
//                         const isOutOfStock = item.status.toLowerCase() === 'out-of-stock';
//                         wishlistDiv.classList.add("wishlist-item"); // Fix class issue
//                         wishlistDiv.innerHTML = `
//                         <div class="popup-left">
//                             <div class="main-image">
//                                 <img id="popup-main-image" src="../admin/${item.image_path}" alt="${item.name}">
//                             </div>
//                         </div>
//                         <div class="popup-right">
//                             <h2>${item.name}</h2> 
//                             <p class="rating">⭐ ${item.rating}.0</p>
//                              <div class="price">
//                                 <span id="popup-price">₹${item.price}</span> 
//                                 <span id="popup-original-price">₹${item.discounted_price}</span>
//                                 <span id="popup-discount">${item.discount}%</span>
//                             </div>
//                             <div class="action-buttons">
//                                 <button class="add-to-cart primary-btn ${isOutOfStock ? 'disabled' : ''}" 
//                                     data-id='${item.product_id}' 
//                                     ${isOutOfStock ? 'disabled' : ''}>
//                                     Add To Cart
//                                 </button>
//                                 <button class="remove-btn" data-id="${item.product_id}"><i class='fa-solid fa-trash'></i></button>
//                             </div>
//                         </div>
//                     `;
//                         wishlistContainer.appendChild(wishlistDiv);
//                     });
//                     attachWishlistActions();
//                 }
//             } else {
//                 console.error("Fetch Wishlist Error:", data.message);
//                 wishlistContainer.innerHTML = `<p>${data.message}</p>`;
//             }
//         })
//         .catch((error) => {
//             console.error("Error fetching wishlist:", error);
//             wishlistContainer.innerHTML = "Failed to load your wishlist. Please try again later.";
//         });


//     // Function to attach event listeners for wishlist actions
//     function attachWishlistActions() {
//         // Remove from wishlist
//         document.querySelectorAll(".remove-btn").forEach((btn) => {
//             btn.addEventListener("click", () => {
//                 const productId = btn.getAttribute("data-id");
//                 if (confirm("Are you sure you want to remove this item from wishlist?")){
//                     fetch("../includes/remove_from_wishlist.php", {
//                         method: "POST",
//                         headers: {
//                             "Content-Type": "application/x-www-form-urlencoded",
//                         },
//                         body: `id=${productId}`
//                     })
//                         .then((response) => response.json())
//                         .then((data) => {
//                             showAlert(data.message, data.success ? "success" : "error");
    
//                             if (data.success) {
//                                 // Remove the item from the DOM
//                                 btn.closest(".wishlist-item").remove();
    
//                                 // Show empty message if no items remain
//                                 if (document.querySelectorAll(".wishlist-item").length === 0) {
//                                     wishlistContainer.innerHTML = "<p>Your wishlist is empty.</p>";
//                                 }
//                             }
//                         })
//                 }
                
//             });
//         });

//         // Add to Cart
//         document.querySelectorAll(".add-to-cart").forEach((btn) => {
//             btn.addEventListener("click", () => {
//                 const productId = btn.getAttribute("data-id");

//                 fetch("../includes/Layout/add_to_cart.php", {
//                     method: "POST",
//                     headers: {
//                         "Content-Type": "application/x-www-form-urlencoded",
//                     },
//                     body: `id=${productId}&quantity=1`
//                 })
//                     .then((response) => response.json())
//                     .then((data) => {
//                         showAlert(data.message, data.success ? "success" : "error");
//                     })
//                     .catch((error) => {
//                         console.error("Error adding to cart:", error);
//                         showAlert("Failed to add item to cart. Please try again.", "error");
//                     });
//             });
//         });
//     }
// });


