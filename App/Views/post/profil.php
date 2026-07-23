<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h1 class="h3 mb-1">Mon profil</h1>
        <p class="text-muted mb-0">Connecté en tant que <?= htmlspecialchars($_SESSION['utilisateur_nom']) ?></p>
    </div>
    <div class="d-flex gap-2">
        <a href="/index.php?controller=post&action=index" class="btn btn-outline-secondary rounded-pill btn-sm px-3">Fil d'actualité</a>
        <a href="/index.php?controller=auth&action=deconnexion" class="btn btn-outline-secondary rounded-pill btn-sm px-3">Se déconnecter</a>
    </div>
</div>

<hr class="mb-4" style="border-color: var(--color-kin); opacity: 0.3;">

<h2 class="h6 text-uppercase text-muted mb-3">Mes publications</h2>

<?php if (empty($posts)): ?>
    <p class="text-muted">Tu n'as encore publié aucun post.</p>
<?php else: ?>
    <div class="row row-cols-2 row-cols-md-3 g-2">
        <?php foreach ($posts as $post): ?>
            <div class="col">
                <?php if ($post->image): ?>
                    <button type="button"
                            class="instagram-tile border-0 p-0"
                            data-bs-toggle="modal"
                            data-bs-target="#postImageModal"
                            data-image="/uploads/<?= htmlspecialchars($post->image) ?>"
                            data-title="<?= htmlspecialchars($post->titreAnime) ?>"
                            data-description="<?= htmlspecialchars($post->description) ?>"
                            data-likes="<?= $post->nbLikes ?>">
                        <img src="/uploads/<?= htmlspecialchars($post->image) ?>" alt="<?= htmlspecialchars($post->titreAnime) ?>">
                    </button>
                <?php else: ?>
                    <div class="instagram-tile-empty"></div>
                <?php endif; ?>
                <p class="small mt-1 mb-0 text-truncate text-muted"><?= htmlspecialchars($post->titreAnime) ?> · <?= $post->nbLikes ?> likes</p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Fenêtre modale pour afficher l'image en entier -->
<div class="modal fade" id="postImageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="postImageModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="postImageModalImg" src="" alt="" class="img-fluid mb-3">
                <p id="postImageModalDescription" class="text-start"></p>
                <p id="postImageModalLikes" class="text-muted text-start mb-0"></p>
            </div>
        </div>
    </div>
</div>

<script>
    const postImageModal = document.getElementById('postImageModal');
    postImageModal.addEventListener('show.bs.modal', (event) => {
        const bouton = event.relatedTarget;
        document.getElementById('postImageModalImg').src = bouton.dataset.image;
        document.getElementById('postImageModalTitle').textContent = bouton.dataset.title;
        document.getElementById('postImageModalDescription').textContent = bouton.dataset.description;
        document.getElementById('postImageModalLikes').textContent = bouton.dataset.likes + ' likes';
    });
</script>