<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Fil d'actualité</h1>
    <div>
        <span class="me-3">Connecté en tant que <?= htmlspecialchars($_SESSION['utilisateur_nom']) ?></span>
        <a href="/index.php?controller=post&action=profil" class="btn btn-outline-secondary btn-sm">Mon profil</a>
        <a href="/index.php?controller=auth&action=deconnexion" class="btn btn-outline-secondary btn-sm">Se déconnecter</a>
    </div>
</div>

<a href="/index.php?controller=post&action=ajouter" class="btn btn-success mb-3">+ Ajouter un post</a>

<form action="/index.php" method="GET" class="row g-2 mb-4">
    <input type="hidden" name="controller" value="post">
    <input type="hidden" name="action" value="index">
    <div class="col-auto">
        <input type="text" name="recherche" class="form-control" placeholder="Rechercher un animé..." value="<?= htmlspecialchars($recherche) ?>">
    </div>
    <div class="col-auto">
        <select name="tri" class="form-select">
            <option value="date" <?= $tri === 'date' ? 'selected' : '' ?>>Plus récent</option>
            <option value="likes" <?= $tri === 'likes' ? 'selected' : '' ?>>Plus liké</option>
        </select>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Filtrer</button>
    </div>
</form>

<?php if (empty($posts)): ?>
    <p>Aucun post pour l'instant.</p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <div class="card mb-3" data-post-id="<?= $post->id ?>">
            <?php if ($post->image): ?>
                <img src="/uploads/<?= htmlspecialchars($post->image) ?>" class="card-img-top" alt="<?= htmlspecialchars($post->titreAnime) ?>" style="max-height: 300px; object-fit: cover;">
            <?php endif; ?>
            <div class="card-body">
                <h2 class="card-title h4"><?= htmlspecialchars($post->titreAnime) ?></h2>
                <p class="text-muted">Publié par <?= htmlspecialchars($post->auteurNom) ?></p>
                <p class="card-text"><?= htmlspecialchars($post->description) ?></p>
                <button class="btn btn-outline-primary btn-like" data-post-id="<?= $post->id ?>">👍 Like</button>
                <span class="nb-likes fw-bold ms-2"><?= $post->nbLikes ?></span> likes
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<script src="/js/likes.js"></script>