<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;

class AuthController extends Controller
{
    public function inscription()
    {
        $this->render('auth/inscription', ['title' => 'Inscription - Animelo']);
    }

    public function traiterInscription()
    {
        $nom = trim($_POST['nom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $motDePasse = $_POST['motDePasse'] ?? '';

        if ($nom === '' || $email === '' || $motDePasse === '') {
            die('Tous les champs sont obligatoires !');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die('Adresse email invalide !');
        }

        $model = new UtilisateurModel();

        if ($model->findByEmail($email)) {
            die('Cet email est déjà utilisé !');
        }

        $motDePasseHache = password_hash($motDePasse, PASSWORD_DEFAULT);
        $id = $model->create($nom, $email, $motDePasseHache);

        session_start();
        $_SESSION['utilisateur_id'] = $id;
        $_SESSION['utilisateur_nom'] = $nom;

        header('Location: /index.php?controller=post&action=index');
        exit;
    }

    public function connexion()
    {
        $this->render('auth/connexion', ['title' => 'Connexion - Animelo']);
    }

    public function traiterConnexion()
    {
        $email = trim($_POST['email'] ?? '');
        $motDePasse = $_POST['motDePasse'] ?? '';

        $model = new UtilisateurModel();
        $utilisateur = $model->findByEmail($email);

        if (!$utilisateur || !password_verify($motDePasse, $utilisateur->motDePasse)) {
            die('Email ou mot de passe incorrect !');
        }

        session_start();
        $_SESSION['utilisateur_id'] = $utilisateur->id;
        $_SESSION['utilisateur_nom'] = $utilisateur->nom;

        header('Location: /index.php?controller=post&action=index');
        exit;
    }

    public function deconnexion()
    {
        session_start();
        session_destroy();
        header('Location: /index.php?controller=auth&action=connexion');
        exit;
    }
}