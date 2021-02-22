
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

// Fonction pour que la modale puisse apparaître lorque l'on click sur supprimer :
$('modal-delete').on('shown.bs.modal', function () {
$('#myInput').trigger('focus')
})

// Ecouteur d'évènement pour la confirmation de suppression :
let supprimer = document.querySelectorAll('.modal-trigger');
console.log(supprimer)
for (let bouton of supprimer){

    bouton.addEventListener("click", function () {  
        
    document.querySelector(".modal-footer a").href = `/admin/animations/supprimer/${this.dataset.id}`
    document.querySelector(".modal-body").innerText = `Etes-vous sûr(e) de vouloir supprimer l'annonce"${this.dataset.titre}"?`
    })
}

