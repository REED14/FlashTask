console.log("vai de capul meu");

function urlParseData(url){
    var GetStart = url.indexOf("?")+1;
    url = url.slice(GetStart);
    url = url.replace(/=/g, ' = "');
    url = url.replace(/&/g, '"; ');
    url = url+'"';
    return url;
}

data = urlParseData(window.location.href);

console.log(data);

try{
    eval(data);
}
catch (e){
    console.log("error occur");
}


var chore_head = document.getElementById("chore-head");
var chore_name = document.getElementById("chore_name_i");
var chore_name_u = document.getElementById("chore_name");
var chore_type_list = document.getElementById("chore-type");

if(typeof chore_type != "undefined"){
    switch(chore_type){
        case "lawn_trim":
            chore_type_list.value = chore_type;
            chore_name.style.display = "none";
            break;

        case "carry_stuff":
            chore_head.style.background = "brown";
            chore_type_list.style.backgroundColor = "brown";
            chore_type_list.value = chore_type;
            chore_name.style.display = "none";
            break;

        case "wash_car":
            chore_head.style.background = "lightblue";
            chore_type_list.style.backgroundColor = "lightblue";
            chore_type_list.value = chore_type;
            chore_name.style.display = "none";
            break;

        case "fix_stuff":
            chore_head.style.background = "purple";
            chore_type_list.style.backgroundColor = "purple";
            chore_type_list.value = chore_type;
            chore_name.style.display = "none";
            break;

        default:
            chore_head.style.background = "gray";
            chore_type_list.style.backgroundColor = "gray";
            chore_type_list.value = "others";
            chore_name.style.display = "block";
            chore_name_u.style.display = "block";
    }
}
else{
    console.log("plm");
}

function changeForm(){
    switch(chore_type_list.value){
        case "lawn_trim":
            chore_head.style.transition = "0.5s linear";
            chore_head.style.background = "rgb(0, 170, 0)";
            chore_type_list.style.backgroundColor = "rgb(0, 170, 0)";
            chore_name.style.display = "none";
            break;

        case "carry_stuff":
            chore_head.style.transition = "0.5s linear";
            chore_head.style.background = "brown";
            chore_type_list.style.backgroundColor = "brown";
            chore_name.style.display = "none";
            break;

        case "wash_car":
            chore_head.style.transition = "0.5s linear";
            chore_head.style.background = "lightblue";
            chore_type_list.style.backgroundColor = "lightblue";
            chore_name.style.display = "none";
            break;

        case "fix_stuff":
            chore_head.style.transition = "0.5s linear";
            chore_head.style.background = "purple";
            chore_type_list.style.backgroundColor = "purple";
            chore_name.style.display = "none";
            break;

        default:
            chore_head.style.transition = "0.5s linear";
            chore_head.style.background = "gray";
            chore_type_list.style.backgroundColor = "gray";
            chore_name.style.display = "block";
            chore_name_u.style.display = "block";
    }
}

var paymentP = document.getElementById("payment");
var etime = document.getElementById("estimated-time");

function textLength(value){
    var maxLength = 4;
    txt = value.toString();
    if(txt.length > maxLength) return false;
    return true;
}

paymentP.oninput = function(){
    if(!textLength(this.value)){
        alert('Payment is too high!');
        this.value=null;
    }
}

etime.oninput = function(){
    if(!textLength(this.value)){
        alert('Time too high!');
        this.value=null;
    }
}