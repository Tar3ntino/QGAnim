
// Script servant à l'ouverture du menu de connexion au clic sur l'élément

document.getElementById('logoconnect').addEventListener('click', function(){
    let sousmenu = document.getElementsByClassName('sousmenu');
    let displaySousMenu = sousmenu[0].style.display;
    console.log(displaySousMenu);
    if (sousmenu[0].style.display === "none"){
        sousmenu[0].style.display = "block";  
        sousmenu[0].style.position = "absolute";
    }else sousmenu[0].style.display = "none"; 
})