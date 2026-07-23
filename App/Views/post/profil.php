<div class="d-flex justify-content-end gap-2 mb-3">
    <a href="/index.php?controller=post&action=index" class="btn btn-outline-secondary rounded-pill btn-sm px-3">
        <i class="bi bi-house"></i> <span class="d-none d-sm-inline">Fil d'actualité</span>
    </a>
    <a href="/index.php?controller=auth&action=deconnexion" class="btn btn-outline-secondary rounded-pill btn-sm px-3">
        <i class="bi bi-box-arrow-right"></i> <span class="d-none d-sm-inline">Se déconnecter</span>
    </a>
</div>

<div class="d-flex align-items-center gap-3 mb-4">
    <form action="/index.php?controller=post&action=modifierPhotoProfil" method="POST" enctype="multipart/form-data" id="avatarForm">
        <label for="avatarInput" class="avatar-upload">
            <?php if ($utilisateur->photoProfil): ?>
                <img src="/uploads/<?= htmlspecialchars($utilisateur->photoProfil) ?>" alt="Photo de profil">
            <?php else: ?>
                <div class="avatar-placeholder">
                    <i class="bi bi-person-fill"></i>
                </div>
            <?php endif; ?>
            <span class="avatar-overlay">
                <i class="bi bi-camera-fill"></i>
            </span>
        </label>
        <input type="file" id="avatarInput" name="photoProfil" class="d-none" accept="image/*" onchange="document.getElementById('avatarForm').submit()">
    </form>

    <div>
        <h1 class="h3 mb-0"><?= htmlspecialchars($utilisateur->nom) ?></h1>
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