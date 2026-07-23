<div class="d-flex justify-content-center">
    <div class="post-form-card">
        <h1 class="h3 mb-1">Nouveau post</h1>
        <p class="text-muted mb-4">Partage l'animé que tu regardes en ce moment.</p>

        <form action="/index.php?controller=post&action=traiterAjout" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titreAnime" class="form-label">Titre de l'animé</label>
                <input type="text" id="titreAnime" name="titreAnime" class="form-control rounded-input" placeholder="Ex : Naruto" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control rounded-input" rows="4" placeholder="Qu'est-ce que tu en as pensé ?"></textarea>
            </div>

            <div class="mb-4">
                <label for="image" class="form-label">Image</label>
                <label for="image" class="image-upload-zone" id="imageUploadZone">
                    <div id="imageUploadPlaceholder">
                        <i class="bi bi-image"></i>
                        <p class="mb-0 small">Clique pour choisir une image</p>
                    </div>
                    <img id="imagePreview" class="d-none">
                </label>
                <input type="file" id="image" name="image" class="d-none" accept="image/*">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary rounded-pill px-4">Publier</button>
                <a href="/index.php?controller=post&action=index" class="btn btn-outline-secondary rounded-pill px-4">Annuler</a>
            </div>
        </form>
    </div>
</div>

<script>
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const imagePlaceholder = document.getElementById('imageUploadPlaceholder');

    imageInput.addEventListener('change', () => {
        const fichier = imageInput.files[0];
        if (fichier) {
            imagePreview.src = URL.createObjectURL(fichier);
            imagePreview.classList.remove('d-none');
            imagePlaceholder.classList.add('d-none');
        }
    });
</script>