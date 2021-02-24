// On récupère le clic sur notre élément "supprimer"
// A l'intérieur de cet élément qui est une balise a, on récupèr ensuite le token
// On envoie la requete à l'url de la balise a pour supprimer l'Image
// Une fois que l'on aura eu la réponse si cela c'est bien passé, on supprime l'image et le lien de notre page

// On le fait sans JQUERY, en Vanilla JS
// Pour attendre que le DOM soit chargé on utilise window.onload
window.onload = () => {
    // Gestion des boutons "Supprimer"
    let links = document.querySelectorAll("[data-delete]")
    
    // On boucle sur links, le for...of... est l'équivalent du foreach en php
    for (link of links){
        // On écoute le clic
        link.addEventListener("click", function(e){
            // La première chose à faire c'est d'empêcher le lien, on empêche la navigation
            e.preventDefault()

            // On demande confirmation
            if(confirm("Voulez-vous supprimer cette image ?")){
                // On envoie une requête Ajax vers le href du lien avec la méthode DELETE
                // this = le lien sur lequel on a cliqué
                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        'X-Requested-With': "XMLHttpRequest",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({"_token": this.dataset.token})
                }).then(
                    // On récupère la réponse en JSON
                    response => response.json()
                ).then(data => {
                    if(data.success)
                        this.parentElement.remove()
                    else
                        alert(data.error)    
                }).catch(e => alert(e))
            }
        })
    }
}