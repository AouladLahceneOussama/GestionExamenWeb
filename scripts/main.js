var moduleBtn=document.querySelector(".modules");
var examItem=document.querySelectorAll(".exam");

moduleBtn.addEventListener("click",function(e){
    element=e.target;
    elementNum=element.attributes.num.value;
    for(var i=0;i<examItem.length;i++){
        if(examItem[i].attributes.num.value==elementNum){
            examItem[i].classList.toggle("back");
            examItem[i].classList.toggle("up");
        }
        if(examItem[i].attributes.num.value!=elementNum && examItem[i].classList.contains("up")){
            examItem[i].classList.toggle("back");
            examItem[i].classList.toggle("up");
        }
    }
});