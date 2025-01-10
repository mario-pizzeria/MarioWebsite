let menuState = false;

window.onload=function(){
    const myOverlay = document.querySelector ("#menuButton");
    
    myOverlay.addEventListener("click", openMenu);
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
    