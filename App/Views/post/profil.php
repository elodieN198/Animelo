<h1>Mon profil</h1>

<p>
    Connecté en tant que <?= htmlspecialchars($_SESSION['utilisateur_nom']) ?> —
    <a href="/index.php?controller=post&action=index">Fil d'actualité</a> |
    <a href="/index.php?controller=auth&action=deconnexion">Se déconnecter</a>
</p>

<h2>Mes publications</h2>

<?php if (empty($posts)): ?>
    <p>Tu n'as encore publié aucun post.</p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <div class="post">
            <h3><?= htmlspecialchars($post->titreAnime) ?></h3>
            <?php if ($post->image): ?>
                <img src="/uploads/<?= htmlspecialchars($post->image) ?>" alt="<?= htmlspecialchars($post->titreAnime) ?>" width="200">
            <?php endif; ?>
            <p><?= htmlspecialchars($post->description) ?></p>
            <p><?= $post->nbLikes ?> likes</p>
        </div>
        <hr>
    <?php endforeach; ?>
<?php endif; ?>