




//to display the navbar when fa-bar icon is clicked
let navbar = document.querySelector('.navbar-items');
let menuIcon = document.querySelector('#menu-icon');
menuIcon.addEventListener('click', ()=>{
   navbar.classList.toggle('active');
    

});

//to hide navbar when individual item of navbar is clicked
let menu_items = document.querySelectorAll('.navbar-items a');

menu_items.forEach((item)=>{
    item.addEventListener('click', ()=>{
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
    slidesContainer.style.transform = `translateX(-${currentSlide * 100}%)`;

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




const carousel = document.querySelector('.feedback-carousel');
const prevBtn = document.querySelector('.prev-btn');
const nextBtn = document.querySelector('.next-btn');

let currentIndex = 0;

prevBtn.addEventListener('click', () => {
  currentIndex = (currentIndex === 0) ? carousel.children.length-1 : currentIndex-1;
  updateCarousel();
});

nextBtn.addEventListener('click', () => {
  currentIndex = (currentIndex + 1) % carousel.children.length;
  updateCarousel();
});

function updateCarousel() {
    const cardWidth = carousel.parentElement.offsetWidth; // Use the container's width
    carousel.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
  }
  




