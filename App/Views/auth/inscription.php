<h1 class="mb-4">Inscription</h1>
<form action="/index.php?controller=auth&action=traiterInscription" method="POST" class="col-md-6">
    <div class="mb-3">
        <label for="nom" class="form-label">Nom :</label>
        <input type="text" id="nom" name="nom" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email :</label>
        <input type="email" id="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="motDePasse" class="form-label">Mot de passe :</label>
        <input type="password" id="motDePasse" name="motDePasse" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">S'inscrire</button>
</form>
<p class="mt-3">Déjà inscrit ? <a href="/index.php?controller=auth&action=connexion">Se connecter</a></p>