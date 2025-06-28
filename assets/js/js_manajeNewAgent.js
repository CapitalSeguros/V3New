window.onload = function(){
    resizeContainer();
}

function resizeContainer(){
    
    var lateralMenu = document.getElementsByClassName("panel_botones")[0];
    var newLateralMenu_ = lateralMenu.innerHTML;
    var menuContainer = document.getElementsByClassName("new-lateral-menu")[0];
    menuContainer.innerHTML = newLateralMenu_;
    var padre = lateralMenu.parentNode;
    padre.removeChild(lateralMenu);
}