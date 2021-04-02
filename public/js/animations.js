// Initialisation de isHorizontal va dépendre du mode paysage ou portrait du mobile et de la taille de l'écran, on ne va pas le mettre par défaut à horizontal=true sinon le mode portrait sera en horizontal au chargement de la page car la rotation vertical/horizontal ne se fait quavec le changement d'etat 
console.log('largeur de la fenetre : ' + window.innerWidth); // 393
if (window.innerWidth < 600){
    var isHorizontal = false;                                   // Initialisation position carousel défaut vertical
}
else{
    var isHorizontal = true;                                   // Initialisation position carousel défaut horizontal
}
console.log("isHorizontal : " + isHorizontal);

// MDN WEB Docs: https://developer.mozilla.org/en-US/docs/Web/API/MediaQueryList/addListener
// Retourne BOOLEN -> matchMedia() : C'est une méthode qui dépend de l'objet window (la fenêtre du navigateur) et qui prend en argument une chaîne de texte contenant l'expression à tester, pour retourner true ou false via sa propriété matches.
var mediaQueryList = window.matchMedia('(min-width: 600px)'); 

function screenTest(e) {                                    // Notre fonction de rappel que l'on exécute lorsque l'état de notre requête multimédia change.
  if (e.matches) {                                          /* the viewport is more than than 600 pixels wide */
    console.log('C\'est un plus grand écran - 600 px de large ou plus');
    angle = theta * selectedIndex * -1;                     // Si index=0 on a angle = (360 / nombre de diapo animations dispo) * 0 *-1
    isHorizontal = true;
    rotateFn = isHorizontal ? 'rotateY' : 'rotateX';        // "RotateFn" prend la propriété Css de la rotation verticale car carousel actuellement horizontal
    carousel.style.transform = 'translateZ(' + -radius + 'px) ' + rotateFn + '(' + angle + 'deg)'; 
    console.log("radius : " + radius)
    console.log("angle : " + angle)
    changeCarousel();

  } else {
    /* the viewport is 600 pixels wide or less */
    console.log('C\'est un petit écran - 600 px de large ou moins');
    // document.body.style.backgroundColor = 'aquamarine';

    angle = theta * selectedIndex * -1;
    isHorizontal = false;
    rotateFn = isHorizontal ? 'rotateY' : 'rotateX'; // Si le carousel est horizontal, la rotation se fera horizontalement
    carousel.style.transform = 'translateZ(' + -radius + 'px) ' + rotateFn + '(' + angle + 'deg)';
    console.log("radius : " + radius)
    console.log("angle : " + angle)
    changeCarousel();
  }
}

// On lance une première fois le ScreenTest même si aucun "évènement de rotation / changement "" de largeur de l'apparail pour savoir si affichage vertical ou horizontal du carousel
mediaQueryList.addListener(screenTest);

var rotateFn = isHorizontal ? 'rotateY' : 'rotateX';       // Variable rotateFn prend la valeur de la propriété css de la rotation a effectuer selon orientation carousel. Cette variable sera nécessaire pour le changement d'affichage responsive.
var radius, theta; 


// Vérifie si l'événement touchstart existe et est le premier déclenché
var clickedEvent = "click"; // Au clic si "touchstart" n'est pas détecté
window.addEventListener('touchstart', function detectTouch() {
	clickedEvent = "touchstart"; // Transforme l'événement en "touchstart"
	window.removeEventListener('touchstart', detectTouch, false);
}, false);


/* CAROUSSEL 3D POUR MON SITE - Commentaires et explications de code :

// On récupère dans la variable:
    - "carousel" : l'intégralité de la div parent qui contient toutes les div enfants de photo
    - "cells" : collection des cellules (l'intégralité des div enfants dans un tableau array)
    - "cellCount" :  définit le nombre de cellule désirée, on affecte la value de cells-range définit dans les options carousels html
    - "selectedIndex" : définit l'index de lecture de la cellule actuelle
    - "cellWidth = carousel.offsetWidth" : propriété en lecture seule qui renvoie la largeur totale d'un élément
    - "cellHeight = carousel.offsetHeight" : propriété en lecture seule, elle renvoie la hauteur totale d'un élément
*/
var carousel = document.querySelector('.carousel');        // on récupère la div parent carousel
var cells = carousel.querySelectorAll('.carousel__cell');  // idem avec toutes les animations
var cellCount;                                             // variable pour définir nombre d'animations                          
var selectedIndex = 0;                                     // initialisation index de lecture
var cellWidth = carousel.offsetWidth;                      // width à 100% du parent .scene (300px)
var cellHeight = carousel.offsetHeight;                    // height à 100% du parent .scene (200px)

 
//console.log(cellWidth, cellHeight);

/*
if (window.matchMedia("(min-width: 600px)").matches) {
    
} else { // Sinon affichage < 600px de large : Rotation verticale
    console.log('On passe en mode vertical');

}*/

function rotateCarousel() {
    var angle = theta * selectedIndex * -1; //Si index=0 on a angle = (360 / nombre de diapo animations dispo) * 0 *-1   
    carousel.style.transform = 'translateZ(' + -radius + 'px) ' + rotateFn + '(' + angle + 'deg)';
}

var prevButton = document.querySelector('.previous-button');
prevButton.addEventListener(clickedEvent, function() {
    selectedIndex--;
    rotateCarousel();
    console.log("index select :" + selectedIndex);
    console.log("nb animations :" + cellsRange.value);
    console.log("index_played = selectedIndex % NbAnimation :" + (selectedIndex % cellsRange.value));
    

    // Si la valeur de l'index devient négative, alors on l'index de la dernière vignette du carousel correspond à l'index du nombre de vignettes du carousel autrement dit la dernière:
    if (selectedIndex < 0) {
        selectedIndex = cellsRange.value;
    }
    var index_played = selectedIndex % cellsRange.value;

    /*On récupère le titre se situant à l'intérieur de la balise h2 généré précédemment lors du tour de boucle à l'initialisation dans le twig et on l'affecte à la div 'title_animation'. Pas besoin de changer la propriété en retirant le display:none, on peut donc laisser les div cachées.*/
    var titleAnimationPlayed = document.getElementById('titre'+index_played).textContent;
    document.getElementById('title_animation').innerHTML = titleAnimationPlayed;

    /*On récupère le scenario de la balise 'paragraphe' généré précédemment lors du tour de boucle à l'initialisation dans le twig et on l'affecte à la div 'scenario_animation'. Pas besoin de changer la propriété en retirant le display:none, on peut donc laisser les div cachées.*/
    var scenarioAnimationPlayed = document.getElementById('scenario'+index_played).textContent;
    document.getElementById('scenario_animation').innerHTML = scenarioAnimationPlayed;

    /*On récupère les caracteristiques techniques de la balise 'paragraphe' généré précédemment lors du tour de boucle à l'initialisation dans le twig et on l'affecte à la div 'scenario_animation'. Pas besoin de changer la propriété en retirant le display:none, on peut donc laisser les div cachées.*/
    var technicalInfoAnimationPlayed = document.getElementById('technical_info'+index_played).textContent;
    document.getElementById('technical_info_animation').innerHTML = technicalInfoAnimationPlayed;

    /*On récupère les caracteristiques techniques de la balise 'paragraphe' généré précédemment lors du tour de boucle à l'initialisation dans le twig et on l'affecte à la div 'scenario_animation'. Pas besoin de changer la propriété en retirant le display:none, on peut donc laisser les div cachées.*/
    var gameAnimationPlayed = document.getElementById('game'+index_played).textContent;
    document.getElementById('game_animation').innerHTML = gameAnimationPlayed;
});

var nextButton = document.querySelector('.next-button');
nextButton.addEventListener(clickedEvent, function() {
    selectedIndex++;
    rotateCarousel();
    console.log("index select :" + selectedIndex);
    console.log("nb animations :" + cellsRange.value);
    console.log("index_played = selectedIndex % NbAnimation :" + (selectedIndex % cellsRange.value));
    var index_played = selectedIndex % cellsRange.value;

    /*On récupère le titre se situant à l'intérieur de la balise h2 généré précédemment lors du tour de boucle à l'initialisation dans le twig et on l'affecte à la div 'title_animation'. Pas besoin de changer la propriété en retirant le display:none, on peut donc laisser les div cachées.*/
    var titleAnimationPlayed = document.getElementById('titre'+index_played).textContent
    document.getElementById('title_animation').innerHTML = titleAnimationPlayed;

    var scenarioAnimationPlayed = document.getElementById('scenario'+index_played).textContent
    
    // On "écrase/ réinitialise" le contenu du précédent scenario lu avec le contenu de scenarioAnimationPlayed pour ne pas qu'il vienne se rajouter au précédent visionnage :
    var scenario_animation = document.getElementById('scenario_animation');   // Soit "scenario_animation" la div ciblé par son Id qui accueillera le scenario à lire
    scenario_animation.textContent = "";                                      // On écrase le scenario précédemment lu
    scenario_animation.innerHTML = scenarioAnimationPlayed;                   // On injecte le nouveau à lire

    var technicalInfoAnimationPlayed = document.getElementById('technical_info'+index_played).textContent

    // On "écrase/ réinitialise" le contenu du précédent scenario lu avec le contenu de technicalInfoAnimationPlayed pour ne pas qu'il vienne se rajouter au précédent visionnage :
    var technical_info_animation = document.getElementById('technical_info_animation');   // Soit "technical_info_animation" la div ciblé par son Id qui accueillera les caracteristiques à lire
    technical_info_animation.textContent = "";                                            // On écrase les caracteristiques précédemment lues
    technical_info_animation.innerHTML = technicalInfoAnimationPlayed;                    // On injecte les nouvelles à lire

    var gameAnimationPlayed = document.getElementById('game'+index_played).textContent

    // On "écrase/ réinitialise" le contenu du précédent scenario lu avec le contenu de gameAnimationPlayed pour ne pas qu'il vienne se rajouter au précédent visionnage :
    var game_animation = document.getElementById('game_animation');   // Soit "game_animation" la div ciblé par son Id qui accueillera le jeu à lire
    game_animation.textContent = "";                                            // On écrase le jeu précédemment lu
    game_animation.innerHTML = gameAnimationPlayed;                    // On injecte le nouveau à lire
});

// cellsRange : On récupère dans cette variable la balise input (class.cells-range). Au sein de celle ci se trouve la valeur du nombre d'animations existantes calculée en récupérant la taille de l'array des animations existantes. Nous utiliserons cette variable dans la fonction changeCaroussel (cf *)
var cellsRange = document.querySelector('.cells-range'); 

/* Si la valeur de la balise change, la fonction changeCarousel s'active et ajuste l'affichage en profondeur pour  une meilleure gestion de la 3D de celui ci */
cellsRange.addEventListener('change', changeCarousel);
cellsRange.addEventListener('input', changeCarousel);

/* 
    - "theta" : définit l'angle de rotation 360 / nombre de cellules dispo au visionnage
    - "cellSize" = isHorizontal ? cellWidth : cellHeight : si le booleen isHorizontal est true, cellSize= largeur sinon hauteur
*/

/* Function verif lecture evenement*/
function testFunction(){
    console.log ("la fonction s'active")
}

/* Cette fonction permet un affichage du carousel en 3D et gère l'inclinaison de l'affichage en profondeur selon le nombre d'animation présente dans la balise input cellesRange */
function changeCarousel() {
    cellCount = cellsRange.value;   // (cf *) On récupère le nombre d'animations existantes    
    theta = 360 / cellCount;        // theta : L'angle de rotation pour chaque clic "Next" ou "Previous". Cette angle va nous intéresser pour le positionnement Css à l'initialisation du carousel également
    var cellSize = isHorizontal ? cellWidth : cellHeight;                  // la taille de la cellule prend la valeur de la longueur si horizontal hauteur si vertical
    radius = Math.round((cellSize / 2) / Math.tan(Math.PI / cellCount));   
    for (var i = 0; i < cells.length; i++) {
        var cell = cells[i];
        if (i < cellCount) {
            // visible cell
            cell.style.opacity = 1;
            var cellAngle = theta * i;
            cell.style.transform = rotateFn + '(' + cellAngle + 'deg) translateZ(' + radius + 'px)';
        } else {
            // hidden cell
            cell.style.opacity = 0;
            cell.style.transform = 'none';
        }
    }
    rotateCarousel();
}
// Etape 1 :
// Lecture des boutons orientations:
// Dans le tour de boucle, on va lire les évènements pour les 2 boutons orientations avec l'appel d'une autre méthode onOrientationChange
var orientationRadios = document.querySelectorAll('input[name="orientation"]'); // Vaut 2

(function() {
    for (var i = 0; i < orientationRadios.length; i++) {        
        var radio = orientationRadios[i];
        // target.addEventListener(type, écouteur [, options]);
        radio.addEventListener('change', onOrientationChange); 
    }
})();

/* Etape 2 : A l'appel de cette fonction:
On cible quel est le bouton coché en déclarant une variable checkedRadio, querySelector va chercher la valeur du 1er argument du document respectant la condition: Premiere balise "input" ayant été cliqué (":checked") et ayant pour nom "orientation" et on renvoie l'élément dans la variable checkedRadio
Si la condition (checkRadio.value =='horizontal' est respectée, isHorizontal sera "TRUE" sinon "FALSE")
Soit rotateFn, la propriété à changer:
    - Si le bouton isHorizontal est coché, on viendra modifier rotateY pour rendre le carousel vertical
    - Si le bouton est coché en vertical, on viendra modifier rotateX pour rendre le carousel horizontal
Une fois que l'on a définit comment l'on devait effectuer la rotation, on appelle la méthode changeCarousel()
 */
function onOrientationChange() {
    var checkedRadio = document.querySelector('input[name="orientation"]:checked'); 
    isHorizontal = checkedRadio.value == 'horizontal';
    rotateFn = isHorizontal ? 'rotateY' : 'rotateX'; // Si le carousel est horizontal, la rotation se fera
    changeCarousel();
}

// set initials
onOrientationChange();

// Récuperation des infos de l'animation selectionnée du carousel avecc JS :
document.getElementById('readIdImage');
