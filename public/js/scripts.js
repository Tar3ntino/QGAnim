// Vérifie si l'événement touchstart existe et est le premier déclenché
var clickedEvent = "click"; // Au clic si "touchstart" n'est pas détecté
window.addEventListener('touchstart', function detectTouch() {
	clickedEvent = "touchstart"; // Transforme l'événement en "touchstart"
	window.removeEventListener('touchstart', detectTouch, false);
}, false);

// Script servant à l'ouverture du menu de connexion au clic sur l'élément
// Logo pour accès à la connexion

// Fonction pour que la modale puisse apparaître lorque l'on click sur supprimer :
$('modal-delete').on('shown.bs.modal', function () {
$('#myInput').trigger('focus')
})

// Ecouteur d'évènement pour la confirmation de SUPPRESSION d'une ANNONCE :
// On stocke tous les boutons qui ont la classe "modal-trigger-animation" :
let supprimerAnim = document.querySelectorAll('.modal-trigger-animation');

// On passe en revue l'ensemble de ces boutons :
for (let bouton of supprimerAnim){

    // Dès que l'on rencontre un bouton ayant été cliqué :
    bouton.addEventListener("click", function () {  

    // On change son attribut, on modifie le lien (initialement vide avec '#' par le lien de suppression)
    document.querySelector(".modal-footer a").href = `/admin/animations/supprimer/${this.dataset.id}`

    // On met à jour le contenu de la modal :
    document.querySelector(".modal-body").innerText = `Etes-vous sûr(e) de vouloir supprimer l'animation "${this.dataset.titre}"?`
    })
}

// Ecouteur d'évènement pour la confirmation de SUPPRESSION d'une SLIDE CAROUSEL IMAGE ACCUEIL :
let supprimerSlide = document.querySelectorAll('.modal-trigger-imgAccueil');
for (let bouton of supprimerSlide){
    bouton.addEventListener("click", function () {  
    document.querySelector(".modal-footer a").href = `/admin/images_carousel_accueil/supprimer/${this.dataset.id}`
    document.querySelector(".modal-body").innerText = `Etes-vous sûr(e) de vouloir supprimer le slide "${this.dataset.id}"?`
    })
}

// Ecouteur d'évènement pour la confirmation de SUPPRESSION d'un UTILISATEUR :
// On stocke tous les boutons qui ont la classe "modal-trigger-user" :
let supprimerUtil = document.querySelectorAll('.modal-trigger-user');
console.log("supprimerUtil :" + supprimerUtil);

// On passe en revue l'ensemble de ces boutons :
for (let bouton of supprimerUtil){

    // Dès que l'on rencontre un bouton ayant été cliqué :
    bouton.addEventListener("click", function () {  

    // On change son attribut, on modifie le lien (initialement vide avec '#' par le lien de suppression)
    document.querySelector(".modal-footer a").href = `/admin/users/supprimer/${this.dataset.id}`

    // On met à jour le contenu de la modal :
    document.querySelector(".modal-body").innerText = `Etes-vous sûr(e) de vouloir supprimer l'utilisateur : "${this.dataset.email}"?`
    }) 
}