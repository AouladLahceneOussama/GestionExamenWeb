var showpass_btn=document.querySelector(".show_pass i");
var input=document.querySelector("form input[type='password']");
var eye_show="fa-eye";
var no_eye_show="fa-eye-slash";

showpass_btn.addEventListener("click",function(){
    showpass_btn.classList.toggle(eye_show);
    showpass_btn.classList.toggle(no_eye_show);
    if(input.type=="password"){
        input.type="text";
    }else{
        input.type="password";
    }
});