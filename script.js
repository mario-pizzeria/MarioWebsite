let menuState = false;


window.onload=function(){
const myOverlay = document.querySelector ("#menuButton");
const foodButton = document.querySelector("#foodButton");

myOverlay.addEventListener("click", openMenu);

foodButton.addEventListener("click", createFood);
}

function openMenu() {
    if (menuState) {
        document.getElementById('menu').style.zIndex=-5;
        document.getElementById('menuBackground').style.zIndex=-5;
        menuState = false;
    }
    else
    {
        document.getElementById('menu').style.zIndex=5;
        document.getElementById('menuBackground').style.zIndex=4;
        menuState = true;
    }
}

function createFood() {
    let foodMenu = document.getElementById("foodlist").getElementsByTagName("ul")[0];
    let newList = document.createElement("li");
    let newFood = document.createElement("p");
    foodMenu.appendChild(newList);
    newList.appendChild(newFood);
    newFood.innerHTML = "Dit is voor eten";
}

