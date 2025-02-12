document.addEventListener("DOMContentLoaded", () => {
    const wishlistButtons = document.querySelectorAll(".wishlist-btn");

    wishlistButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const card = btn.closest(".card");
            const productId = card.getAttribute("data-id"); // Get product ID from the card

            // Send AJAX request to add product to wishlist
            fetch("../includes/add-to-wishlist.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `id=${productId}`, // Pass the product ID
            })
                .then((response) => response.json())
                .then((data) => {
                    // Use your custom showAlert function
                    showAlert(data.message, data.success ? "success" : "error");
                })
                .catch((error) => {
                    console.error("Error:", error);
                    showAlert("An error occurred. Please try again.", "error");
                });
        });
    });
});



document.addEventListener("DOMContentLoaded", () => {
    const wishlistContainer = document.getElementById("wishlist-container");
    const table = document.createElement('table');
    // Fetch wishlist items from the server
    fetch("../includes/fetch_wishlist.php")
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                const items = data.data;
                console.log(items)
                if (items.length === 0) {
                    wishlistContainer.innerHTML = "<p>Your wishlist is empty.</p>";
                } else {
                    wishlistContainer.innerHTML = "";

                    items.forEach((item) => {
                        const row = document.createElement("tr");

                        row.innerHTML = `
                <td><img src="../admin/${item.image_path}" alt="${item.name}"></td>
                <td>${item.name}</td>
                <td>⭐ ${item.rating}</td>
                <td>₹${item.discounted_price}</td>
                <td>
                    <button class="add-to-cart primary-btn" data-id='${item.product_id}'>Add To Cart </button>
                </td>
                <td>
                    <button class="remove-btn secondary-btn" data-id="${item.product_id}">Remove</button>
                </td>
            `;

            table.appendChild(row);
            wishlistContainer.appendChild(table);
                    });



                    // Attach event listeners for remove and add-to-cart buttons
                    attachWishlistActions();
                }
            } else {
                wishlistContainer.innerHTML = `<p>${data.message}</p>`;
            }
        })
        .catch((error) => {
            console.error("Error fetching wishlist:", error);
            wishlistContainer.innerHTML = "<p>Failed to load your wishlist. Please try again later.</p>";
        });

    // Function to attach event listeners for wishlist actions
    function attachWishlistActions() {
        // Remove from wishlist
        document.querySelectorAll(".remove-btn").forEach((btn) => {
            btn.addEventListener("click", () => {
                const productId = btn.getAttribute("data-id");

                fetch("../includes/remove_from_wishlist.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: `id=${productId}`
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
                        console.error("Error adding to cart:", error);
                        showAlert("Failed to add item to cart. Please try again.", "error");
                    });
            });
        });
    }
});
