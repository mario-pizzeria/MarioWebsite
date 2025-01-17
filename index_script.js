let menuState = false;

let vid = document.getElementById("myVideo");
vid.playbackRate = 0.6;

window.onload=function(){
const myOverlay = document.querySelector ("#menuButton");
const reserveer = document.getElementById("Reserveer");
const bestellen = document.getElementById("Bestellen");
const overons = document.getElementById("Overons");
const contact = document.getElementById("Contact");
const events = document.getElementById("Events");

myOverlay.addEventListener("click", openMenu);

reserveer.addEventListener("mouseover", purpleOn);
reserveer.addEventListener("mouseout", purpleOff);

bestellen.addEventListener("mouseover", redOn);
bestellen.addEventListener("mouseout", redOff);

overons.addEventListener("mouseover", yellowOn);
overons.addEventListener("mouseout", yellowOff);

contact.addEventListener("mouseover", greenOn);
contact.addEventListener("mouseout", greenOff);

events.addEventListener("mouseover", blueOn);
events.addEventListener("mouseout", blueOff);

}

function openMenu() 
{
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

function purpleOn()
{
    document.getElementById("Purple").style.display="inline";
    document.getElementById("Art1").style.display="inline";
}

function purpleOff()
{
    document.getElementById("Purple").style.display="none";
    document.getElementById("Art1").style.display="none";
}

function redOn()
{
    document.getElementById("Red").style.display="inline";
    document.getElementById("Art2").style.display="inline";
}

function redOff()
{
    document.getElementById("Red").style.display="none";
    document.getElementById("Art2").style.display="none";
}

function yellowOn()
{
    document.getElementById("Yellow").style.display="inline";
    document.getElementById("Art3").style.display="inline";
}

function yellowOff()
{
    document.getElementById("Yellow").style.display="none";
    document.getElementById("Art3").style.display="none";
}

function greenOn()
{
    document.getElementById("Green").style.display="inline";
    document.getElementById("Art4").style.display="inline";
}

function greenOff()
{
    document.getElementById("Green").style.display="none";
    document.getElementById("Art4").style.display="none";
}

function blueOn()
{
    document.getElementById("Blue").style.display="inline";
    document.getElementById("Art5").style.display="inline";
}

function blueOff()
{
    document.getElementById("Blue").style.display="none";
    document.getElementById("Art5").style.display="none";
}
