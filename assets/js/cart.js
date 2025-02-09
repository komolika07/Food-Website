// Add event listener for all "Add to Cart" buttons
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function () {
        const productId = this.getAttribute('data-id');

        // Send AJAX request
        fetch('../includes/Layout/add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${productId}`, // Send product ID
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message,"success"); // Success message
                } else {
                    showAlert(data.message,"error"); // Error message
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('An error occurred. Please try again.',"error");
            });
    });
});
