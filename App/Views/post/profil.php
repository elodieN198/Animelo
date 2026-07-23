<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Mon profil</h1>
    <div>
        <span class="me-3">Connecté en tant que <?= htmlspecialchars($_SESSION['utilisateur_nom']) ?></span>
        <a href="/index.php?controller=post&action=index" class="btn btn-outline-secondary btn-sm">Fil d'actualité</a>
        <a href="/index.php?controller=auth&action=deconnexion" class="btn btn-outline-secondary btn-sm">Se déconnecter</a>
    </div>
</div>

<h2 class="h4 mb-3">Mes publications</h2>

<?php if (empty($posts)): ?>
    <p>Tu n'as encore publié aucun post.</p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <div class="card mb-3">
            <?php if ($post->image): ?>
                <img src="/uploads/<?= htmlspecialchars($post->image) ?>" class="card-img-top" alt="<?= htmlspecialchars($post->titreAnime) ?>" style="max-height: 300px; object-fit: cover;">
            <?php endif; ?>
            <div class="card-body">
                <h3 class="card-title h5"><?= htmlspecialchars($post->titreAnime) ?></h3>
                <p class="card-text"><?= htmlspecialchars($post->description) ?></p>
                <p class="text-muted mb-0"><?= $post->nbLikes ?> likes</p>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>