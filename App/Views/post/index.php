<h1>Fil d'actualité</h1>

<p>
    Connecté en tant que <?= htmlspecialchars($_SESSION['utilisateur_nom']) ?> —
    <a href="/index.php?controller=post&action=profil">Mon profil</a> |
    <a href="/index.php?controller=auth&action=deconnexion">Se déconnecter</a>
</p>

<a href="/index.php?controller=post&action=ajouter">+ Ajouter un post</a>

<form action="/index.php" method="GET">
    <input type="hidden" name="controller" value="post">
    <input type="hidden" name="action" value="index">
    <input type="text" name="recherche" placeholder="Rechercher un animé..." value="<?= htmlspecialchars($recherche) ?>">
    <select name="tri">
        <option value="date" <?= $tri === 'date' ? 'selected' : '' ?>>Plus récent</option>
        <option value="likes" <?= $tri === 'likes' ? 'selected' : '' ?>>Plus liké</option>
    </select>
    <button type="submit">Filtrer</button>
</form>

<?php if (empty($posts)): ?>
    <p>Aucun post pour l'instant.</p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <div class="post" data-post-id="<?= $post->id ?>">
            <h2><?= htmlspecialchars($post->titreAnime) ?></h2>
            <p>Publié par <?= htmlspecialchars($post->auteurNom) ?></p>
            <?php if ($post->image): ?>
                <img src="/uploads/<?= htmlspecialchars($post->image) ?>" alt="<?= htmlspecialchars($post->titreAnime) ?>" width="200">
            <?php endif; ?>
            <p><?= htmlspecialchars($post->description) ?></p>
            <p>
                <button class="btn-like" data-post-id="<?= $post->id ?>">👍 Like</button>
                <span class="nb-likes"><?= $post->nbLikes ?></span> likes
            </p>
        </div>
        <hr>
    <?php endforeach; ?>
<?php endif; ?>