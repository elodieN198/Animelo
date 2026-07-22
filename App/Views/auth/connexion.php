<h1>Connexion</h1>
<form action="/index.php?controller=auth&action=traiterConnexion" method="POST">
    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="motDePasse">Mot de passe :</label>
    <input type="password" id="motDePasse" name="motDePasse" required>
    <br>
    <button type="submit">Se connecter</button>
</form>
<p>Pas encore de compte ? <a href="/index.php?controller=auth&action=inscription">S'inscrire</a></p>