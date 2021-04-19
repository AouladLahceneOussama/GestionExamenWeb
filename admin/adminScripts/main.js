var menuBtn=document.getElementById("menu_btn");
var nav=document.getElementById("header");
var navList=document.querySelector("header nav ul");

menuBtn.addEventListener("click",function(){
    nav.classList.toggle("max_height");
    nav.classList.toggle("min_height");
    navList.classList.toggle("visible");
});