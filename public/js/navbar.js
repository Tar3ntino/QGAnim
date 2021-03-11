// Vérifie si l'événement touchstart existe et est le premier déclenché
var clickedEvent = "click"; // Au clic si "touchstart" n'est pas détecté
window.addEventListener('touchstart', function detectTouch() {
	clickedEvent = "touchstart"; // Transforme l'événement en "touchstart"
	window.removeEventListener('touchstart', detectTouch, false);
}, false);



const navbar = document.getElementById("navbar");
const navbarToggle = navbar.querySelector(".navbar-toggle");


function openMobileNavbar() {
  navbar.classList.add("opened");
  navbarToggle.setAttribute("aria-label", "Close navigation menu.");
}

function closeMobileNavbar() {
  navbar.classList.remove("opened");
  navbarToggle.setAttribute("aria-label", "Open navigation menu.");
}

// ***************************************************************
// Gestion du clic sur le bouton burger :
// ***************************************************************
navbarToggle.addEventListener(clickedEvent, () => {
  if (navbar.classList.contains("opened")) {
    closeMobileNavbar();
  } else {
    openMobileNavbar();
  }
});

// ***************************************************************
// Gestion du clic sur les liens du menu déroulant ouvert gauche :
// ***************************************************************
const navbarMenu = navbar.querySelector(".navbar-menu");
const navbarLinksContainer = navbar.querySelector(".navbar-links");

navbarLinksContainer.addEventListener(clickedEvent, (clickEvent) => {
  clickEvent.stopPropagation();
});

navbarMenu.addEventListener(clickedEvent, closeMobileNavbar);

// ***************************************************************
// Gestion du clic sur le bouton de connexion :
// ***************************************************************

const boutonConnexion = document.getElementById("butn_connect");
const boutonConnexionSousMenu = navbar.querySelector(".sousmenu");

boutonConnexion.addEventListener(clickedEvent, () =>{
    if(getComputedStyle(boutonConnexionSousMenu).display != "none"){
        boutonConnexionSousMenu.style.display = "none";
    } else{
        boutonConnexionSousMenu.style.display = "block";
    }
})


// TO BE DELETE :
// document
//   .getElementById("options")
//   .querySelectorAll("input[name='navtype']")
//   .forEach((option) => {
//     option.addEventListener("change", (e) => {
//       const navType = e.target.id.split("-").join(" ");
//       navbarMenu.classList = "navbar-menu " + navType;
//     });
//   });