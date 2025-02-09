// //to display the navbar when fa-bar icon is clicked
// let navbar = document.querySelector('.navbar-items');
// let menuIcon = document.querySelector('#menu-icon');
// menuIcon.addEventListener('click', ()=>{
//    navbar.classList.toggle('active');
    

// });

// //to hide navbar when individual item of navbar is clicked
// let menu_items = document.querySelectorAll('.navbar-items a');

// menu_items.forEach((item)=>{
//     item.addEventListener('click', ()=>{
//         navbar.classList.toggle('active');
//     })
// });
    





document.addEventListener("DOMContentLoaded", () => {
    const words = ["Tasty", "Delicious", "Flavorful", "Savory", "Mouthwatering"];
    const changingWord = document.getElementById("changing-word");
    let wordIndex = 0;

    function updateWord() {
        if (changingWord) { // Ensure the element exists
            changingWord.textContent = words[wordIndex];
            wordIndex = (wordIndex + 1) % words.length; // Cycle through the words
        }
    }

    // Start updating the word every 5 seconds
    setInterval(updateWord, 2000);
});
