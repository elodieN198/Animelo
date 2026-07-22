document.addEventListener('DOMContentLoaded', () => {
    const boutonsLike = document.querySelectorAll('.btn-like');

    boutonsLike.forEach((bouton) => {
        bouton.addEventListener('click', () => {
            const postId = bouton.dataset.postId;

            fetch('/index.php?controller=post&action=like', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'postId=' + encodeURIComponent(postId),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.nbLikes !== undefined) {
                        const compteur = bouton.parentElement.querySelector('.nb-likes');
                        compteur.textContent = data.nbLikes;
                    }
                })
                .catch((error) => {
                    console.error('Erreur lors du like :', error);
                });
        });
    });
});