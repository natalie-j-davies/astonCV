window.onload=function(){
    emailValidator();
}
function emailValidator(){
    let email = document.getElementById("email").value;
    let conEmail = document.getElementById("conEmail").value;
    let text;
        if(email===conEmail){
            text = "";
        }else {
            text = "error: email is not the same as confirmed email";
        }
    document.getElementById("text").innerHTML = text;
      }