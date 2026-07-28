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
            $this->erreur('Tous les champs sont obligatoires !');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->erreur('Adresse email invalide !');
        }

        $model = new UtilisateurModel();

        if ($model->findByEmail($email)) {
            $this->erreur('Cet email est déjà utilisé !');
        }

        $motDePasseHache = password_hash($motDePasse, PASSWORD_DEFAULT);
        $id = $model->create($nom, $email, $motDePasseHache);

        session_regenerate_id(true);
        $_SESSION['utilisateur_id'] = $id;
        $_SESSION['utilisateur_nom'] = $nom;

        header('Location: /?controller=post&action=index');
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
            $this->erreur('Email ou mot de passe incorrect !', 401);
        }

        session_regenerate_id(true);
        $_SESSION['utilisateur_id'] = $utilisateur->id;
        $_SESSION['utilisateur_nom'] = $utilisateur->nom;

        header('Location: /?controller=post&action=index');
        exit;
    }

    public function deconnexion()
    {
        session_destroy();
        header('Location: /?controller=auth&action=connexion');
        exit;
    }
}