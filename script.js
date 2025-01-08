let menuState = false;

window.onload=function(){
const myOverlay = document.querySelector ("#menuButton");
const backButt = document.querySelector("backarrow")

myOverlay.addEventListener("click", openMenu);
backButt.addEventListener("hover", buttHover);
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

function buttHover(){
    document.getElementsByClassName("backarrow").src = "backarrow_hvr.png";
}