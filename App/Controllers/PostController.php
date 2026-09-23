<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\UtilisateurModel;

class PostController extends Controller
{
    private const TYPES_IMAGE_AUTORISES = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private const TAILLE_IMAGE_MAX = 5 * 1024 * 1024;

    public function index()
    {
        $this->verifierAuth();

        $tri = $_GET['tri'] ?? 'date';
        $recherche = $_GET['recherche'] ?? '';

        $model = new PostModel();
        $posts = $model->findAll($tri, $recherche);

        $this->render('post/index', [
            'title' => 'Fil d\'actualité - Animelo',
            'posts' => $posts,
            'tri' => $tri,
            'recherche' => $recherche,
        ]);
    }

    public function ajouter()
    {
        $this->verifierAuth();

        $this->render('post/ajouter', ['title' => 'Nouveau post - Animelo']);
    }

    public function traiterAjout()
    {
        $this->verifierAuth();

        $titreAnime = trim($_POST['titreAnime'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($titreAnime === '') {
            $this->erreur('Le titre de l\'animé est obligatoire !');
        }

        $nomImage = null;

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $nomImage = $this->traiterUploadImage($_FILES['image'], 'post_');
        }

        $model = new PostModel();
        $model->create($titreAnime, $description, $nomImage, $_SESSION['utilisateur_id']);

        header('Location: /?controller=post&action=index');
        exit;
    }

    public function supprimer()
    {
        $this->verifierAuth();

        $postId = (int) ($_GET['id'] ?? 0);
        $model = new PostModel();
        $post = $model->findById($postId);

        if (!$post) {
            $this->erreur('Ce post n\'existe pas.', 404);
        }

        if ($post->utilisateurId !== (int) $_SESSION['utilisateur_id']) {
            $this->erreur('Tu ne peux pas supprimer un post qui ne t\'appartient pas.', 403);
        }

        if ($post->image) {
            $cheminImage = __DIR__ . '/../../public/uploads/' . $post->image;
            if (file_exists($cheminImage)) {
                unlink($cheminImage);
            }
        }

        $model->delete($postId);

        header('Location: /?controller=post&action=profil');
        exit;
    }

    public function like()
    {
        $this->verifierAuth();

        header('Content-Type: application/json');

        $postId = (int) ($_POST['postId'] ?? 0);

        if ($postId <= 0) {
            http_response_code(400);
            echo json_encode(['erreur' => 'ID de post invalide']);
            exit;
        }

        $model = new PostModel();
        $nouveauTotal = $model->incrementerLikes($postId);

        echo json_encode(['nbLikes' => $nouveauTotal]);
        exit;
    }

    public function profil()
    {
        $this->verifierAuth();

        $utilisateurModel = new UtilisateurModel();
        $utilisateur = $utilisateurModel->findById($_SESSION['utilisateur_id']);

        $postModel = new PostModel();
        $posts = $postModel->findByUser($_SESSION['utilisateur_id']);

        $this->render('post/profil', [
            'title' => 'Mon profil - Animelo',
            'posts' => $posts,
            'utilisateur' => $utilisateur,
        ]);
    }

    public function modifierPhotoProfil()
    {
        $this->verifierAuth();

        if (isset($_FILES['photoProfil']) && $_FILES['photoProfil']['error'] === UPLOAD_ERR_OK) {
            $nomFichier = $this->traiterUploadImage($_FILES['photoProfil'], 'avatar_');

            $model = new UtilisateurModel();
            $model->updatePhotoProfil($_SESSION['utilisateur_id'], $nomFichier);
        }

        header('Location: /?controller=post&action=profil');
        exit;
    }

    private function traiterUploadImage(array $fichier, string $prefixe): string
    {
        if ($fichier['size'] > self::TAILLE_IMAGE_MAX) {
            $this->erreur('L\'image est trop volumineuse (5 Mo maximum).');
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $typeReel = finfo_file($finfo, $fichier['tmp_name']);

        if (!in_array($typeReel, self::TYPES_IMAGE_AUTORISES, true)) {
            $this->erreur('Format d\'image non autorisé. Utilise un JPEG, PNG, GIF ou WebP.');
        }

        $extension = pathinfo($fichier['name'], PATHINFO_EXTENSION);
        $nomFichier = uniqid($prefixe) . '.' . $extension;
        $destination = __DIR__ . '/../../public/uploads/' . $nomFichier;
        move_uploaded_file($fichier['tmp_name'], $destination);

        return $nomFichier;
    }

    private function verifierAuth()
    {
        if (!isset($_SESSION['utilisateur_id'])) {
            header('Location: /?controller=auth&action=connexion');
            exit;
        }
    }
}