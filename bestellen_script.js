let typeID;
let pizzaMenu = 0;
let vegaMenu = 0;
let drankMenu = 0;
let desertMenu = 0;
let cartOpen = false;
let x = 1;
 
//array with the cart of items.
//matrix with the item data --> https://www.youtube.com/watch?v=SmJNeJuLmVo&ab_channel=BroCode


window.onload=function(){

    const typePizza = document.getElementById("type1");
    const typeVega = document.getElementById("type2");
    const typeDrank = document.getElementById("type3");
    const typeDesert = document.getElementById("type4");
    const cart = document.getElementById("cart");

    typePizza.addEventListener("click", 
        function(){
            typeID = 1;
            document.getElementById("type1").style.color="rgb(0, 0, 0)";
            document.getElementById("type2").style.setProperty("color", "rgb(255, 255, 255)");
            document.getElementById("type3").style.setProperty("color", "rgb(255, 255, 255)");
            document.getElementById("type4").style.setProperty("color", "rgb(255, 255, 255)");
            switchType()
        });
    typeVega.addEventListener("click",
        function(){ 
            typeID = 2;
            document.getElementById("type2").style.setProperty("color", "rgb(0, 0, 0)");
            document.getElementById("type1").style.setProperty("color", "rgb(255, 255, 255)");
            document.getElementById("type3").style.setProperty("color", "rgb(255, 255, 255)");
            document.getElementById("type4").style.setProperty("color", "rgb(255, 255, 255)");
            switchType()
        });
    typeDrank.addEventListener("click", 
        function(){ 
            typeID = 3;
            document.getElementById("type3").style.setProperty("color", "rgb(0, 0, 0)");
            document.getElementById("type1").style.setProperty("color", "rgb(255, 255, 255)");
            document.getElementById("type2").style.setProperty("color", "rgb(255, 255, 255)");
            document.getElementById("type4").style.setProperty("color", "rgb(255, 255, 255)");
            switchType()
        });
    typeDesert.addEventListener("click", 
        function(){
            typeID = 4;
            document.getElementById("type4").style.setProperty("color", "rgb(0, 0, 0)");
            document.getElementById("type1").style.setProperty("color", "rgb(255, 255, 255)");
            document.getElementById("type2").style.setProperty("color", "rgb(255, 255, 255)");
            document.getElementById("type3").style.setProperty("color", "rgb(255, 255, 255)");
            switchType()
        });
    cart.addEventListener("click", openCart);
}

function createFood() {
    let foodMenu = document.getElementById("foodlist").getElementsByTagName("ul")[0];
    let newList = document.createElement("li");
    let newFood = document.createElement("p");
    let newButton = document.createElement("button");
    foodMenu.appendChild(newList);
    newList.appendChild(newFood);
    newList.appendChild(newButton);
    newFood.innerHTML = appel + x + " $" + x + "," + x + x;
    newButton.innerHTML = "+";
    newButton.addEventListener("click", addItem);
}

function switchType()
{   
    const list = document.getElementById("foodlist").getElementsByTagName("ul")[0];
    let menuAmount;

    switch(typeID) {
    case 1:
        menuAmount = pizzaMenu;
        break;
    case 2:
        menuAmount = vegaMenu;
        break;
    case 3:
        menuAmount = drankMenu; 
        break;
    case 4:
        menuAmount = desertMenu;
        break;
    }   

    while (list.hasChildNodes()) {
        list.removeChild(list.firstChild);
    }

    for(let i = 0; i < menuAmount; i++)
    {
        createFood();
    }

}

function openCart()
{
    if(openCart)
    {
        document.getElementById("overlay_cart").style.display='none';
        openCart = false;
    }
    else
    {
        document.getElementById("overlay_cart").style.display='inline';
        openCart = true;
    }
}




