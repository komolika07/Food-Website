// document.addEventListener('DOMContentLoaded', function() {
//     document.getElementById('is-deal').addEventListener('change', function() {
//         const isChecked = this.checked;
//         document.getElementById('regular-form').style.display = isChecked ? 'none' : 'block';
//         document.getElementById('deal-form').style.display = isChecked ? 'block' : 'none';

//         // Make deal fields required only if deal is checked
//         document.getElementById('deal-name').required = isChecked;
//         document.getElementById('deal-price').required = isChecked;
//         document.getElementById('deal-validity').required = isChecked;
//     });
// });
document.getElementById('is-deal').addEventListener('change', function() {
    const isChecked = this.checked;
    const regularForm = document.getElementById('regular-form');
    const dealForm = document.getElementById('deal-form');

    if (isChecked) {
        regularForm.style.display = 'none';
        dealForm.style.display = 'block';

        // Remove required attributes from regular menu form fields
        regularForm.querySelectorAll("[required]").forEach(field => {
            field.removeAttribute("required");
        });

        // Add required attributes to deal form fields
        dealForm.querySelectorAll("input, select").forEach(field => {
            field.setAttribute("required", "required");
        });

    } else {
        regularForm.style.display = 'block';
        dealForm.style.display = 'none';

        // Add required attributes back to regular menu form fields
        regularForm.querySelectorAll("input, select").forEach(field => {
            field.setAttribute("required", "required");
        });

        // Remove required attributes from deal form fields
        dealForm.querySelectorAll("[required]").forEach(field => {
            field.removeAttribute("required");
        });
    }
});

document.querySelector(".Add-item-btn").addEventListener("click", function(event) {
    console.log("Submit button clicked"); // Debugging
});
