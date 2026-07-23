<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="/css/theme.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a href="/index.php?controller=home&action=index" class="navbar-brand mb-0 h1 text-decoration-none">Animelo</a>
        </div>
    </nav>

    <div class="container">
        <?= $content ?>
    </div>

    <footer class="mt-5 py-5 border-top" style="background-color: var(--color-sumi); border-color: var(--color-kin) !important;">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h2 class="h5" style="color: var(--color-washi);">Animelo</h2>
                    <p class="small mb-0" style="color: #bbb;">La plateforme de partage pour fans d'animation japonaise.</p>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h2 class="h6 text-uppercase" style="color: var(--color-kin);">Navigation</h2>
                    <ul class="list-unstyled small">
                        <li><a href="/index.php?controller=post&action=index" class="text-decoration-none" style="color: #bbb;">Fil d'actualité</a></li>
                        <li><a href="/index.php?controller=post&action=profil" class="text-decoration-none" style="color: #bbb;">Mon profil</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h2 class="h6 text-uppercase" style="color: var(--color-kin);">Contact</h2>
                    <ul class="list-unstyled small">
                        <li><a href="mailto:contact@animelo.fr" class="text-decoration-none" style="color: #bbb;">contact@animelo.fr</a></li>
                        <li><a href="https://github.com/elodieN198/Animelo" target="_blank" class="text-decoration-none" style="color: #bbb;">Code source sur GitHub</a></li>
                    </ul>
                </div>
            </div>
            <hr style="border-color: var(--color-kin); opacity: 0.3;">
            <p class="small text-center mb-0" style="color: #bbb;">
                &copy; <?= date('Y') ?> Animelo — Projet réalisé dans le cadre du Titre Professionnel Développeur Web et Web Mobile — CEFii
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>