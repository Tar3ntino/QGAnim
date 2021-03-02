const navbar = document.getElementById("navbar");
const myheader = document.getElementById("myheader");
const navbarToggle = myheader.querySelector(".navbar-toggle");


/* Activer ou désactiver l'icône du hamburger
C'est le bon moment pour coder la logique de basculement du menu de navigation afin que nous puissions tester que le bouton bascule fonctionne: */

function openMobileNavbar() {
    console.log("openMobileNavbar s'ouvre")
    navbar.classList.add("opened");
    // navbarMenu.classList.remove("sidebar.left");
    navbarToggle.setAttribute("aria-label", "Close navigation menu.");
  }
  
  function closeMobileNavbar() {
    navbar.classList.remove("opened");
    navbarMenu.classList.add("sidebar.left");
    navbarToggle.setAttribute("aria-label", "Open navigation menu.");

  }
  
  navbarToggle.addEventListener("click", () => {
    if (navbar.classList.contains("opened")) {
      closeMobileNavbar();
    } else {
      openMobileNavbar();
    }
  });

// Une dernière chose avant de styliser la version de bureau. Ajoutez ceci à votre JavaScript:
// Fondamentalement, cela permet à l'utilisateur de fermer le menu de navigation lorsqu'il clique sur .navbar-menu. Mais nous devons arrêter la propagation des clics afin que les clics sur .navbar-linksne pas bouillonner et déclencher une fermeture.
// Allez-y et testez cela de votre côté pour vous assurer que la version mobile fonctionne.

const navbarMenu = navbar.querySelector(".navbar-menu");
const navbarLinksContainer = navbar.querySelector(".navbar-links");

navbarLinksContainer.addEventListener("click", (clickEvent) => {
  clickEvent.stopPropagation();
});

navbarMenu.addEventListener("click", closeMobileNavbar);
