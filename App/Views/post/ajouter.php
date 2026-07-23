<h1 class="mb-4">Ajouter un post</h1>

<form action="/index.php?controller=post&action=traiterAjout" method="POST" enctype="multipart/form-data" class="col-md-6">
    <div class="mb-3">
        <label for="titreAnime" class="form-label">Titre de l'animé :</label>
        <input type="text" id="titreAnime" name="titreAnime" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description :</label>
        <textarea id="description" name="description" class="form-control" rows="4"></textarea>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image :</label>
        <input type="file" id="image" name="image" class="form-control" accept="image/*">
    </div>
    <button type="submit" class="btn btn-primary">Publier</button>
</form>

<p class="mt-3"><a href="/index.php?controller=post&action=index">Retour au fil d'actualité</a></p>