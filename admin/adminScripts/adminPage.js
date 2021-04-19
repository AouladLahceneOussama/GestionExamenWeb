var myTable=document.getElementById("my_table");

function show(element){
    element.classList.toggle("input_edit");
    element.classList.toggle("input_edit_show");
}
myTable.addEventListener("click",function(e){
    var element=e.target;
    var num=element.attributes.num.value;
    element=myTable.children.item(0).children.item(parseInt(num)+1).children.item(0);
    show(element);
});

var modale=document.querySelector(".modale");
var closeBtn=document.getElementById("close");

if(closeBtn){
    closeBtn.addEventListener("click",function(){
        modale.style.opacity="0";
        modale.style.visibility="hidden";

    });
}