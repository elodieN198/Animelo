<h1 class="mb-4">Connexion</h1>
<form action="/index.php?controller=auth&action=traiterConnexion" method="POST" class="col-md-6">
    <div class="mb-3">
        <label for="email" class="form-label">Email :</label>
        <input type="email" id="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="motDePasse" class="form-label">Mot de passe :</label>
        <input type="password" id="motDePasse" name="motDePasse" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>
<p class="mt-3">Pas encore de compte ? <a href="/index.php?controller=auth&action=inscription">S'inscrire</a></p>