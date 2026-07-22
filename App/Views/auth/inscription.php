<h1>Inscription</h1>
<form action="/index.php?controller=auth&action=traiterInscription" method="POST">
    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" required>
    <br>
    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="motDePasse">Mot de passe :</label>
    <input type="password" id="motDePasse" name="motDePasse" required>
    <br>
    <button type="submit">S'inscrire</button>
</form>
<p>Déjà inscrit ? <a href="/index.php?controller=auth&action=connexion">Se connecter</a></p>