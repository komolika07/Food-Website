document.querySelectorAll('.submenu-toggle').forEach(button => {
    button.addEventListener('click', function () {
        const submenu = this.nextElementSibling;
        const isVisible = submenu.style.display === 'block';
        document.querySelectorAll('.submenu').forEach(sub => sub.style.display = 'none');
        submenu.style.display = isVisible ? 'none' : 'block';
    });
});
    
    
    
    
    
    
    
    /* Toggle dropdown menu on click */
    const dropdownButton = document.querySelector('.dropdown button');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    dropdownButton.addEventListener('click', function (event) {
        event.stopPropagation(); // Prevent click from propagating to the document
        const isVisible = dropdownMenu.style.display === 'inline-block';
        dropdownMenu.style.display = isVisible ? 'none' : 'inline-block';
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function () {
        dropdownMenu.style.display = 'none';
    });
