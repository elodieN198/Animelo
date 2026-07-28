<div class="d-flex justify-content-center">
    <div class="post-form-card text-center">
        <div class="mb-3" style="font-size: 2.5rem; color: var(--color-shu);">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <h1 class="h4 mb-2">Oups, une erreur est survenue</h1>
        <p class="text-muted mb-4"><?= htmlspecialchars($message) ?></p>
        <a href="/index.php?controller=post&action=index" class="btn btn-primary rounded-pill px-4">Retour au fil d'actualité</a>
    </div>
</div>