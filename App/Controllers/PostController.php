<?php

namespace App\Controllers;

use App\Models\PostModel;

class PostController extends Controller
{
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
            die('Le titre de l\'animé est obligatoire !');
        }

        $nomImage = null;

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $nomImage = uniqid('post_') . '.' . $extension;
            $destination = __DIR__ . '/../../public/uploads/' . $nomImage;
            move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        }

        $model = new PostModel();
        $model->create($titreAnime, $description, $nomImage, $_SESSION['utilisateur_id']);

        header('Location: /index.php?controller=post&action=index');
        exit;
    }

    public function profil()
    {
        $this->verifierAuth();

        $model = new PostModel();
        $posts = $model->findByUser($_SESSION['utilisateur_id']);

        $this->render('post/profil', [
            'title' => 'Mon profil - Animelo',
            'posts' => $posts,
        ]);
    }

    private function verifierAuth()
    {
        if (!isset($_SESSION['utilisateur_id'])) {
            header('Location: /index.php?controller=auth&action=connexion');
            exit;
        }
    }
}