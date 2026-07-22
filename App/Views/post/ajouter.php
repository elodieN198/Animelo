<h1>Ajouter un post</h1>

<form action="/index.php?controller=post&action=traiterAjout" method="POST" enctype="multipart/form-data">
    <label for="titreAnime">Titre de l'animé :</label>
    <input type="text" id="titreAnime" name="titreAnime" required>
    <br>
    <label for="description">Description :</label>
    <textarea id="description" name="description"></textarea>
    <br>
    <label for="image">Image :</label>
    <input type="file" id="image" name="image" accept="image/*">
    <br>
    <button type="submit">Publier</button>
</form>

<p><a href="/index.php?controller=post&action=index">Retour au fil d'actualité</a></p>