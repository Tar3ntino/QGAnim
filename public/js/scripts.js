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

// Ecouteur d'évènement pour la confirmation de SUPPRESSION d'une ANIMATION :
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
let supprimerUtil = document.querySelectorAll('.modal-trigger-user');
for (let bouton of supprimerUtil){
    bouton.addEventListener("click", function () {
    document.querySelector(".modal-footer a").href = `/admin/users/supprimer/${this.dataset.id}`
    document.querySelector(".modal-body").innerText = `Etes-vous sûr(e) de vouloir supprimer l'utilisateur : "${this.dataset.email}"?`
    }) 
}

// Ecouteur d'évènement pour la confirmation de SUPPRESSION d'une DEMANDE :
let supprimerDemande = document.querySelectorAll('.modal-trigger-demande');
for (let bouton of supprimerDemande){
    bouton.addEventListener("click", function () {
    document.querySelector(".modal-footer a").href = `/admin/demandes/supprimer/${this.dataset.id}`
    document.querySelector(".modal-body").innerText = `Etes-vous sûr(e) de vouloir supprimer cette demande : "${this.dataset.eventLocation}"?`
    }) 
}


// Ecouteur d'évènement pour l'affichage modal des DEMANDES UTILISATEUR sur son compte perso :
let detailDemandeUtil = document.querySelectorAll('.modal-trigger-demande-detail');
for (let bouton of detailDemandeUtil){
    bouton.addEventListener("click", function () {  
    document.getElementById("titleDetailDemande").innerText = `Détail de la demande envoyé le ${this.dataset.createdat}`
    document.getElementById("DetailDemandeContent").innerHTML = `<p>Envoyé le ${this.dataset.createdat}</p>` + `<p>Statut : ${this.dataset.status}</p>`+ `<p>Type d'évènement : ${this.dataset.eventtype}</p>`+ `<p>Lieu de l'évènement : ${this.dataset.eventlocation}</p>`+`<p> Date : ${this.dataset.eventdate}</p>`+`<p>Nb de personnes : ${this.dataset.numberpeople}</p>`+`<p> Horaires animation : ${this.dataset.animationschedules}</p>`+`<p>Budget :${this.dataset.budgetclient}</p>`+`<p>Autres Commentaires : ${this.dataset.othercomments} </p>`
    }) 
}
