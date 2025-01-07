let menuState = false;

window.onload=function(){
const myOverlay = document.querySelector ("#menuButton");

myOverlay.addEventListener("click", openMenu);
}
function openMenu() {
    if (menuState) {
        document.getElementById('Menu').style.zIndex=-5;
        menuState = false;
    }
    else
    {
        document.getElementById('Menu').style.zIndex=5;
        menuState = true;
    }
}