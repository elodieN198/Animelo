/**
 * Système de likes en AJAX.
 *
 * Au clic sur un bouton Like, envoie l'identifiant du post au serveur,
 * puis met à jour le compteur avec le nouveau total, sans recharger la page.
 */

// Attend que la page soit entièrement chargée avant d'installer les écouteurs 
document.addEventListener('DOMContentLoaded', () => {
    // Récupère tous les boutons Like de la page 
    const boutonsLike = document.querySelectorAll('.btn-like');

    boutonsLike.forEach((bouton) => {
        bouton.addEventListener('click', () => {
            // Identifiant du post, lu dans l'attribut data-post-id du bouton 
            const postId = bouton.dataset.postId;

            // Envoie la requête en POST au contrôleur, sans recharger la page 
            fetch('/?controller=post&action=like', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'postId=' + encodeURIComponent(postId),
            })
                // Lit la réponse JSON renvoyée par le serveur 
                .then((response) => response.json())
                .then((data) => {
                    // Met à jour uniquement le compteur de ce post 
                    if (data.nbLikes !== undefined) {
                        const compteur = bouton.parentElement.querySelector('.nb-likes');
                        compteur.textContent = data.nbLikes;
                    }
                })
                // En cas d'erreur réseau ou serveur, l'affiche dans la console 
                .catch((error) => {
                    console.error('Erreur lors du like :', error);
                });
        });
    });
});