var sdButton = document.getElementsByClassName("sidebar-button");
var chList = document.getElementsByClassName("chores-list");
var scrl = document.getElementsByClassName("scrl");
var header = document.getElementById("headboy");
var loc = document.getElementsByClassName("location");

window.addEventListener("scroll", function(){
    if(window.scrollY>0){
        
        sdButton[0].style.transition = "0.5s linear";
        sdButton[0].style.display="none";
        chList[0].style.transition = "0.5s linear";
        chList[0].style.display="none";
        
        scrl[0].style.transition = "0.5s linear";
        scrl[0].style.display = "block";
        scrl[1].style.transition = "0.5s linear";
        scrl[1].style.display = "block";
        
        
        header.style.transition = "0.5s linear";
        header.style.background = "#FFFFFF";
        header.style.borderBottom = "#FFFFFF";
        
        loc[0].style.transition = "0.5s linear";
        loc[0].style.color = "green";
    }
    else{
        sdButton[0].style.transition = "0.5s linear";
        sdButton[0].style.display="block";
        chList[0].style.transition = "0.5s linear";
        chList[0].style.display="block";
        
        scrl[0].style.transition = "0.5s linear";
        scrl[0].style.display = "none";
        scrl[1].style.transition = "0.5s linear";
        scrl[1].style.display = "none";
        
        
        header.style.transition = "0.5s linear";
        header.style.background = "none";
        
        loc[0].style.transition = "0.5s linear";
        loc[0].style.color = "white";
    }
  });