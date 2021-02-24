/* CAROUSSEL 3D POUR MON SITE - Commentaires et explications de code :

// On récupère dans la variable:
    - "carousel" : l'intégralité de la div parent qui contient toutes les div enfants de photo
    - "cells" : collection des cellules (l'intégralité des div enfants dans un tableau array)
    - "cellCount" :  définit le nombre de cellule désirée, on affecte la value de cells-range définit dans les options carousels html
    - "selectedIndex" : définit l'index de lecture de la cellule actuelle
    - "cellWidth = carousel.offsetWidth" : propriété en lecture seule qui renvoie la largeur totale d'un élément
    - "cellHeight = carousel.offsetHeight" : propriété en lecture seule, elle renvoie la hauteur totale d'un élément
*/
var carousel = document.querySelector('.carousel');         // on récupère la div parent carousel
var cells = carousel.querySelectorAll('.carousel__cell');   // idem avec toutes les animations
var cellCount;                                              
var selectedIndex = 0;
//console.log(selectedIndex);
var cellWidth = carousel.offsetWidth;
var cellHeight = carousel.offsetHeight;
var isHorizontal = true;
var rotateFn = isHorizontal ? 'rotateY' : 'rotateX';
var radius, theta;
//console.log(cellWidth, cellHeight);

// C'est cette fonction que nous souhaitons activer avec une rotation verticale dans le matchMedia (media query Javascript)
// La largeur minimum de l'affichage est 600 px inclus 

//var angle;
//console.log(window.matchMedia("(min-width: 600px)").matches);

var mediaQueryList = window.matchMedia('(min-width: 600px)');

function screenTest(e) {
  if (e.matches) {
    /* the viewport is more than than 600 pixels wide */
    console.log('This is a narrow screen — 600px wide or less.');
    document.body.style.backgroundColor = 'pink';

    angle = theta * selectedIndex * -1; // Si index=0 on a angle = (360 / nombre de diapo animations dispo) * 0 *-1
    isHorizontal = true;
    rotateFn = isHorizontal ? 'rotateY' : 'rotateX'; // Si le carousel est horizontal, la rotation se fera verticalement
    carousel.style.transform = 'translateZ(' + -radius + 'px) ' + rotateFn + '(' + angle + 'deg)'; 
    changeCarousel();

  } else {
    /* the viewport is 600 pixels wide or less */
    console.log('This is a wide screen — more than 600px wide.');
    document.body.style.backgroundColor = 'aquamarine';

    angle = theta * selectedIndex * -1;
    isHorizontal = false;
    rotateFn = isHorizontal ? 'rotateY' : 'rotateX'; // Si le carousel est horizontal, la rotation se fera horizontalement
    carousel.style.transform = 'translateZ(' + -radius + 'px) ' + rotateFn + '(' + angle + 'deg)';
    changeCarousel();
  }
}
mediaQueryList.addListener(screenTest);


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
prevButton.addEventListener('click', function() {
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
    var titleAnimationPlayed = document.getElementById('titre'+index_played).textContent
    document.getElementById('title_animation').innerHTML = titleAnimationPlayed;
});

var nextButton = document.querySelector('.next-button');
nextButton.addEventListener('click', function() {
    selectedIndex++;
    rotateCarousel();
    console.log("index select :" + selectedIndex);
    console.log("nb animations :" + cellsRange.value);
    console.log("index_played = selectedIndex % NbAnimation :" + (selectedIndex % cellsRange.value));
    var index_played = selectedIndex % cellsRange.value;

    /*On récupère le titre se situant à l'intérieur de la balise h2 généré précédemment lors du tour de boucle à l'initialisation dans le twig et on l'affecte à la div 'title_animation'. Pas besoin de changer la propriété en retirant le display:none, on peut donc laisser les div cachées.*/
    var titleAnimationPlayed = document.getElementById('titre'+index_played).textContent
    document.getElementById('title_animation').innerHTML = titleAnimationPlayed;
});

// cellsRange : La balise input contenant le nombre d'animation
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
    cellCount = cellsRange.value;
    theta = 360 / cellCount;
    var cellSize = isHorizontal ? cellWidth : cellHeight;
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
