var divPlusIcon=document.querySelector(".plus_icon");
var plsuIcon=document.getElementById("plus_icon");
var profile=document.querySelector(".profile_container");

divPlusIcon.addEventListener("click",function(){
    plsuIcon.classList.toggle("rotate");
    profile.classList.toggle("translate_profile_left");
    profile.classList.toggle("translate_profile_right");
});

var editForm=document.getElementById("edit_form");
var searchBtn=document.getElementById("search");
var date=document.getElementById("date");
var start=document.getElementById("start");
var end=document.getElementById("end");
var touch=document.getElementById("touch");

if(searchBtn){
    searchBtn.addEventListener("click",function(){

        date=document.getElementById("date").value;
        start=document.getElementById("start").value;
        end=document.getElementById("end").value;
        if(date && start && end){
            localStorage.setItem("date",date);
            localStorage.setItem("start",start);
            localStorage.setItem("end",end);
            localStorage.setItem("clickIndice",1);
        }
    });
}
window.addEventListener("load",function(){
    
    var dateVal=localStorage.getItem("date");
    var startVal=localStorage.getItem("start");
    var endVal=localStorage.getItem("end");
    var clickindice=localStorage.getItem("clickIndice");

    if(dateVal && startVal && endVal && clickindice){
        date.value=dateVal;
        start.value=startVal;
        end.value=endVal;

        if(clickindice==1){
            touch.classList.toggle("touch");
            touch.classList.toggle("dont_touch");
            localStorage.setItem("clickIndice",0);
        }
    }
    
});

var add=document.getElementById("add");
var valideData=document.getElementById("valide_data");

if(add){
    add.addEventListener("click",function(){

        var prof1=document.getElementById("prof1").value;
        var prof2=document.getElementById("prof2").value;
        var prof3=document.getElementById("prof3").value;
        var prof4=document.getElementById("prof4").value;
        var prof5=document.getElementById("prof5").value;
        var error=0;
        valideData.classList.toggle("text_translate_0");
        valideData.classList.remove("text_translate_100");

        if(prof1=='none' || prof2=='none' || prof3=='none'){
            valideData.innerHTML="at least choose 3 professors";
            error=1;
        }
        else{
            
            if(prof1!='none' && ( prof1==prof2 || prof1==prof3 || prof1==prof4 || prof1==prof5)){
                valideData.innerHTML="Choose different professors";
                error=1;
            }

            if(prof2!='none' && (prof2==prof3 || prof2==prof4 || prof2==prof5)){
                valideData.innerHTML="Choose different professors";
                error=1;
            }

            if(prof3!='none' && (prof3==prof4 || prof3==prof5)){
                valideData.innerHTML="Choose different professors";
                error=1;
            }

            if(prof4!='none' && (prof4==prof5)){
                valideData.innerHTML="Choose different professors";
                error=1; 
            }
        }
        if(error==0) add.type="submit";
    });
}

var update=document.getElementById("update");
if(update){
    update.addEventListener("click",function(){

        editForm.setAttribute("action","index.php?update=success");
        var prof1=document.getElementById("prof1").value;
        var prof2=document.getElementById("prof2").value;
        var prof3=document.getElementById("prof3").value;
        var prof4=document.getElementById("prof4").value;
        var prof5=document.getElementById("prof5").value;
        var error=0;
        valideData.classList.toggle("text_translate_0");
        valideData.classList.remove("text_translate_100");

        if(prof1=='none' || prof2=='none' || prof3=='none'){
            valideData.innerHTML="at least choose 3 professors";
            error=1;
        }
        else{
            
            if(prof1!='none' && ( prof1==prof2 || prof1==prof3 || prof1==prof4 || prof1==prof5)){
                valideData.innerHTML="Choose different professors";
                error=1;
            }

            if(prof2!='none' && (prof2==prof3 || prof2==prof4 || prof2==prof5)){
                valideData.innerHTML="Choose different professors";
                error=1;
            }

            if(prof3!='none' && (prof3==prof4 || prof3==prof5)){
                valideData.innerHTML="Choose different professors";
                error=1;
            }

            if(prof4!='none' && (prof4==prof5)){
                valideData.innerHTML="Choose different professors";
                error=1; 
            }
        }
        if(error==0) update.type="submit";
    });
}

var editBtn=document.querySelectorAll(".edit");
for(var i=0;i<editBtn.length;i++){
    editBtn[i].addEventListener("click",function(){
        localStorage.clear();
    });
}

