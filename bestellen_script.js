let typeID;
let pizzaMenu = 0;
let vegaMenu = 0;
let drankMenu = 0;
let desertMenu = 0;



window.onload=function(){

    const foodButton = document.getElementById("foodButton");
    const typePizza = document.getElementById("type1");
    const typeVega = document.getElementById("type2");
    const typeDrank = document.getElementById("type3");
    const typeDesert = document.getElementById("type4");
    
    foodButton.addEventListener("click", function()
    {
        switch(typeID) {
            case 1:
                pizzaMenu += 1; 
                createFood();
                break;
            case 2:
                vegaMenu += 1; 
                createFood();
                break;
            case 3:
                drankMenu += 1; 
                createFood();
                break;
            case 4:
                desertMenu += 1; 
                createFood();
                break;
        }   
    });

    typePizza.addEventListener("click", function(){ typeID = 1; switchType()});
    typeVega.addEventListener("click", function(){ typeID = 2; switchType()});
    typeDrank.addEventListener("click", function(){ typeID = 3; switchType()});
    typeDesert.addEventListener("click", function(){ typeID = 4; switchType()});
}

function createFood() {
    let foodMenu = document.getElementById("foodlist").getElementsByTagName("ul")[0];
    let newList = document.createElement("li");
    let newFood = document.createElement("p");
    foodMenu.appendChild(newList);
    newList.appendChild(newFood);
    newFood.innerHTML = "Dit is voor eten";
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



