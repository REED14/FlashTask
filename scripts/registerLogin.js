var passReg = document.getElementById("passreg");
var passRegRepeat =  document.getElementById("passreg_repeat");

var submitReg =  document.getElementById("submitReg");
var notEnough = document.getElementById("notenough");
var notTheSame = document.getElementById("notthesame");
var notStrong = document.getElementById("notstrong");

//console.log("ghoeirhgi");

/*
writeinBody();


function writeinBody(){
    document.getElementById('somewhere').innerHTML+='<a>test</a>';
}

*/
function isStrong(pass){
    if(pass.value.match(/[!, @. #, $, %, ^, &, *]/) && pass.value.match(/[A-Z]/) && 
    pass.value.match(/[0-9]/) && pass.value.match(/[a-z]/)){
        return true;
    }
    return false;
}

function isLong(pass){
    if(pass.value.length >= 8){
        return true;
    }
    return false;
}

function isTheSame(pass, pass2){
    if(pass.value == pass2.value){
        return true;
    }
    return false;
}

passReg.addEventListener('input', () => {
    if (!isLong(passReg)) 
    {
        submitReg.style.display="none";
        notEnough.style.display="block";
    }
    else if(!isStrong(passReg))
    {
        notEnough.style.display="none";
        notStrong.style.display="block";
    }
    else{
        notStrong.style.display="none";
        notEnough.style.display="none";
        submitReg.style.display="none";
    }
});

passRegRepeat.addEventListener('input', () => {
    if (!isTheSame(passReg, passRegRepeat)) 
    {
        submitReg.style.display="none";
        notTheSame.style.display="block";
    }
    else
    {
        submitReg.style.display="block";
        notTheSame.style.display="none";
    }
});

var btns_lgn = document.getElementById("logsign");
var signup = document.getElementById("register_form");
var login = document.getElementById("login_form");

function showLogin(){
    login.style.display = "block";
    btns_lgn.style.display = "none";

    login.style.opacity = "0%";
    login.style.position = "relative";
    login.style.top = "-100px";
    login.style.transition = "0.5s linear";

    let x = setTimeout(function(){
        login.style.top = "0px";
        login.style.opacity = "100%"; console.log("mor");
        }, 50);
}

function showSignup(){
    signup.style.display = "block";
    btns_lgn.style.display = "none";

    signup.style.opacity = "0%";
    signup.style.position = "relative";
    signup.style.top = "-100px";
    signup.style.transition = "0.5s linear";
    let x = setTimeout(function(){
        signup.style.top = "0px";
        signup.style.opacity = "100%"; console.log("mor");
        }, 50);
}

function showBtnsOnLogin(){
    btns_lgn.style.display = "block";
    login.style.display = "none";

    btns_lgn.style.opacity = "0%";
    btns_lgn.style.position = "relative";
    btns_lgn.style.top = "-100px";
    btns_lgn.style.transition = "0.5s linear";
    let x = setTimeout(function(){
        btns_lgn.style.top = "0px";
        btns_lgn.style.opacity = "100%";
        }, 50);
}

function showBtnsOnSignup(){
    btns_lgn.style.display = "block";
    signup.style.display = "none";

    btns_lgn.style.opacity = "0%";
    btns_lgn.style.position = "relative";
    btns_lgn.style.top = "-100px";
    btns_lgn.style.transition = "0.5s linear";
    let x = setTimeout(function(){
        btns_lgn.style.top = "0px";
        btns_lgn.style.opacity = "100%";
        }, 50);
}