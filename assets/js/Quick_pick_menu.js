
    // const MenuItems = document.getElementById("menu-category");
    // const contentDivs = document.querySelectorAll(".Menu-cards-container");
    // const listItems = document.querySelectorAll(".menu-category li");

// console.log(MenuItems);
// console.log(contentDivs[0]);
// console.log(listItems);

    // Show associated content on list item click
    // listItems.forEach(function(item) {
    //     item.addEventListener("click", function() {
    //         // Hide all content divs
    //         contentDivs.forEach(function(div) {
    //             div.style.display = "none";
    //         });

    //         listItems.forEach(function(li) {
    //             li.classList.remove("active");
    //         });
            
    //         // Get the target content div
    //         const target = this.getAttribute("data-target");
    //         const targetDiv = document.getElementById(target);

    //         // Show the target content div
    //         if (targetDiv) {
    //             targetDiv.style.display = "block";
    //         }

    //         //for active class item style
    //         this.classList.add("active");

    //         // Hide the menu (useful for mobile)
    //         // MenuItems.style.display = "none";
    //     });
    // });


//menu list

const All_list = [
    {
        id: 1,
        name: "Veg Fried Rice",
        Rating: 5.0,
        image: './Home/images/vegFriedRice.png',
        price: 120,
    },
    {
        id: 2,
        name: "Veg Hakka Noodles",
        Rating: 3.5,
        image: './Home/images/vegFriedRice.png',
        price: 100,
    },
    {
        id: 3,
        name: "Veg Manchurian",
        Rating: 5.0,
        image: './Home/images/vegFriedRice.png',
        price: 100,
    },
    {
        id: 4,
        name: "Veg Paneer Crispy",
        Rating: 5.0,
        image: './Home/images/vegFriedRice.png',
        price: 100,
    },
];



// let product_container = document.querySelector(".product-container");

// All_list.forEach(item => {
//     const itemCard = document.createElement('div');
//     itemCard.classList.add('itemCard');

//     itemCard.innerHTML = `
//             <div class="itemImg">
//               <img src="${item.image}">
//             </div>
//             <div class="like"><i class="fas fa-heart"></i></div>
//             <div class="flex">
//               <div class="item-name"><i class="fas fa-circle"></i> ${item.name}</div>
//               <div class="rating"><i class="fas fa-star"></i>${item.Rating}</div>
//             </div>
//             <div class="item-price"> ₹${item.price}</div>
//             <div class="flex">
//               <button class="orderNow order" id="orderNow order">Order Now</button>
//               <button class="AddToCartBtn" id="AddToCartBtn"><i class="fa-solid fa-plus"></i></button>
//             </div>
//     `
// //Adding itemCard div in product container
//     product_container.appendChild(itemCard);
// });

// let All_items_container = document.querySelector(".All");

// All_list.forEach(item => {
//     const Product_Slider= document.createElement('div');
//     itemCard.classList.add('product-Slider');

//     const ul_list = document.createElement('ul');
//     ul_list.classList.add('cs-hidden');
//     ul_list.id='autoWidth';
//     console.log(ul_list.id);
//     Product_Slider.appendChild(ul_list);
//     ul_list.innerHTML = `
//           <li class="item">
//                 <div class="product-box">
//                   <div class="itemImg">
//                     <img src="${image}">
//                   </div>
//                   <div class="like"><i class="fas fa-heart"></i></div>
//                   <div class="flex">
//                     <div class="item-name"><i class="fas fa-circle"></i>${name}</div>
//                     <div class="rating"><i class="fas fa-star"></i>${Rating}</div>
//                   </div>
//                   <div class="item-price">Rs. ${price}</div>
//                   <div class="flex">
//                     <button class="orderNow order" id="orderNow order">Order Now</button>
//                     <button class="AddToCartBtn" id="AddToCartBtn"><i class="fa-solid fa-plus"></i></button>
//                   </div>
//                 </div>
//          </li>
//     `
// //Adding itemCard div in product container
//     All_items_container.appendChild(Product_Slider);
// });

