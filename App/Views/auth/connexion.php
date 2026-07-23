<div class="d-flex justify-content-center">
    <div class="post-form-card">
        <h1 class="h3 mb-1">Connexion</h1>
        <p class="text-muted mb-4">Nous sommes heureux de te revoir sur Animelo.</p>

        <form action="/index.php?controller=auth&action=traiterConnexion" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control rounded-input" placeholder="toi@exemple.com" required>
            </div>
            <div class="mb-4">
                <label for="motDePasse" class="form-label">Mot de passe</label>
                <input type="password" id="motDePasse" name="motDePasse" class="form-control rounded-input" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary rounded-pill w-100">Se connecter</button>
        </form>

        <p class="text-center small text-muted mt-4 mb-0">
            Pas encore de compte ?
            <a href="/index.php?controller=auth&action=inscription" style="color: var(--color-shu);">S'inscrire</a>
        </p>
    </div>
</div>