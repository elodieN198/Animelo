<div class="d-flex justify-content-center">
    <div class="post-form-card">
        <h1 class="h3 mb-1">Inscription</h1>
        <p class="text-muted mb-4">Rejoins la communauté Animelo.</p>

        <form action="/index.php?controller=auth&action=traiterInscription" method="POST">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" id="nom" name="nom" class="form-control rounded-input" placeholder="Ton nom" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control rounded-input" placeholder="toi@exemple.com" required>
            </div>
            <div class="mb-4">
                <label for="motDePasse" class="form-label">Mot de passe</label>
                <input type="password" id="motDePasse" name="motDePasse" class="form-control rounded-input" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary rounded-pill w-100">S'inscrire</button>
        </form>

        <p class="text-center small text-muted mt-4 mb-0">
            Déjà inscrit ?
            <a href="/index.php?controller=auth&action=connexion" style="color: var(--color-shu);">Se connecter</a>
        </p>
    </div>
</div>