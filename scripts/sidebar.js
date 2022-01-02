const Sidebar = document.getElementsByClassName('sidebar');
const Cover = document.getElementsByClassName('cover-side');

function CloseSidebar()
{
    Sidebar[0].style.transition = "transform 0.3s linear 0s";
    Sidebar[0].style.transform = "translateX(-400px)"; 
    Cover[0].style.transition = "transform 0.3s linear 0s";
    Cover[0].style.opacity = "0%";
    Cover[0].style.display = "none";
}

function OpenSidebar()
{
    Sidebar[0].style.transition = "transform 0.3s linear 0s";
    Sidebar[0].style.transform = "translateX(400px)";
    Cover[0].style.transition = "transform 0.3s linear 0s";
    Cover[0].style.display = "block";
    Cover[0].style.opacity = "40%";
}

