<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h1 class="h3 mb-0">Fil d'actualité</h1>
    </div>
    <div class="d-flex gap-2">
        <a href="/index.php?controller=post&action=profil" class="btn btn-outline-secondary rounded-pill btn-sm px-3">
            <i class="bi bi-person"></i> <span class="d-none d-sm-inline">Mon profil</span>
        </a>
        <a href="/index.php?controller=auth&action=deconnexion" class="btn btn-outline-secondary rounded-pill btn-sm px-3">
            <i class="bi bi-box-arrow-right"></i> <span class="d-none d-sm-inline">Se déconnecter</span>
        </a>
    </div>
</div>

<hr class="mb-4" style="border-color: var(--color-kin); opacity: 0.3;">

<div class="d-flex flex-nowrap align-items-center gap-2 mb-4">
    <form action="/index.php" method="GET" class="search-filter-bar flex-grow-1" id="filterForm">
        <input type="hidden" name="controller" value="post">
        <input type="hidden" name="action" value="index">
        <input type="hidden" name="tri" id="triInput" value="<?= htmlspecialchars($tri) ?>">

        <i class="bi bi-search"></i>
        <input type="text" name="recherche" class="search-filter-input" placeholder="Rechercher un animé..." value="<?= htmlspecialchars($recherche) ?>">

        <span class="search-filter-divider"></span>

        <div class="dropdown">
            <button class="filter-trigger" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Trier">
                <i class="bi bi-filter"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><button type="button" class="dropdown-item tri-option <?= $tri === 'date' ? 'active' : '' ?>" data-tri="date">Plus récent</button></li>
                <li><button type="button" class="dropdown-item tri-option <?= $tri === 'likes' ? 'active' : '' ?>" data-tri="likes">Plus liké</button></li>
            </ul>
        </div>
    </form>

    <a href="/index.php?controller=post&action=ajouter" class="btn btn-primary rounded-pill btn-new-post flex-shrink-0">
        <i class="bi bi-plus-lg"></i> <span class="d-none d-sm-inline">Nouveau post</span>
    </a>
</div>

<?php if (empty($posts)): ?>
    <p class="text-muted">Aucun post pour l'instant.</p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <div class="card mb-3 border-0 shadow-sm" data-post-id="<?= $post->id ?>">
            <?php if ($post->image): ?>
                <button type="button"
                        class="feed-image-btn border-0 p-0"
                        data-bs-toggle="modal"
                        data-bs-target="#postImageModal"
                        data-image="/uploads/<?= htmlspecialchars($post->image) ?>"
                        data-title="<?= htmlspecialchars($post->titreAnime) ?>"
                        data-description="<?= htmlspecialchars($post->description) ?>"
                        data-likes="<?= $post->nbLikes ?>">
                    <img src="/uploads/<?= htmlspecialchars($post->image) ?>" alt="<?= htmlspecialchars($post->titreAnime) ?>">
                </button>
            <?php endif; ?>
            <div class="card-body">
                <h2 class="card-title h5 mb-1"><?= htmlspecialchars($post->titreAnime) ?></h2>
                <p class="text-muted small mb-2">Publié par <?= htmlspecialchars($post->auteurNom) ?></p>
                <p class="card-text"><?= htmlspecialchars($post->description) ?></p>
                <button class="btn btn-outline-primary rounded-pill btn-sm btn-like" data-post-id="<?= $post->id ?>">👍 Like</button>
                <span class="nb-likes fw-bold ms-2"><?= $post->nbLikes ?></span> likes
            </div>
        </div>
    <?php endforeach; ?>
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

    document.querySelectorAll('.tri-option').forEach((bouton) => {
        bouton.addEventListener('click', () => {
            document.getElementById('triInput').value = bouton.dataset.tri;
            document.getElementById('filterForm').submit();
        });
    });
</script>

<script src="/js/likes.js"></script>