<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;

/**
 * Gère l'authentification : inscription, connexion et déconnexion.
 */
class AuthController extends Controller
{
    /**
     * Affiche le formulaire d'inscription.
     */
    public function inscription()
    {
        $this->render('auth/inscription', ['title' => 'Inscription - Animelo']);
    }

    /**
     * Traite le formulaire d'inscription.
     *
     * Vérifie les champs et le format de l'email, refuse un email déjà utilisé,
     * hache le mot de passe, crée le compte puis connecte l'utilisateur.
     */
    public function traiterInscription()
    {
        $nom = trim($_POST['nom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $motDePasse = $_POST['motDePasse'] ?? '';

        if ($nom === '' || $email === '' || $motDePasse === '') {
            $this->erreur('Tous les champs sont obligatoires !', 400, '/?controller=auth&action=inscription', 'Retour à l\'inscription');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->erreur('Adresse email invalide !', 400, '/?controller=auth&action=inscription', 'Retour à l\'inscription');
        }

        $model = new UtilisateurModel();

        if ($model->findByEmail($email)) {
            $this->erreur('Cet email est déjà utilisé !', 400, '/?controller=auth&action=inscription', 'Retour à l\'inscription');
        }

        // Le mot de passe n'est jamais stocké en clair : seul son hachage est enregistré
        $motDePasseHache = password_hash($motDePasse, PASSWORD_DEFAULT);
        $id = $model->create($nom, $email, $motDePasseHache);

        // Nouvel identifiant de session pour éviter la fixation de session
        session_regenerate_id(true);
        $_SESSION['utilisateur_id'] = $id;
        $_SESSION['utilisateur_nom'] = $nom;

        header('Location: /?controller=post&action=index');
        exit;
    }

    /**
     * Affiche le formulaire de connexion.
     */
    public function connexion()
    {
        $this->render('auth/connexion', ['title' => 'Connexion - Animelo']);
    }

    /**
     * Traite le formulaire de connexion.
     *
     * Vérifie l'email et le mot de passe (comparé à son hachage),
     * puis enregistre l'utilisateur en session.
     */
    public function traiterConnexion()
    {
        $email = trim($_POST['email'] ?? '');
        $motDePasse = $_POST['motDePasse'] ?? '';

        $model = new UtilisateurModel();
        $utilisateur = $model->findByEmail($email);

        // Même message dans les deux cas, pour ne pas révéler si l'email existe
        if (!$utilisateur || !password_verify($motDePasse, $utilisateur->motDePasse)) {
            $this->erreur('Email ou mot de passe incorrect !', 401, '/?controller=auth&action=connexion', 'Retour à la connexion');
        }

        // Nouvel identifiant de session pour éviter la fixation de session
        session_regenerate_id(true);
        $_SESSION['utilisateur_id'] = $utilisateur->id;
        $_SESSION['utilisateur_nom'] = $utilisateur->nom;

        header('Location: /?controller=post&action=index');
        exit;
    }

    /**
     * Déconnecte l'utilisateur en détruisant sa session.
     */
    public function deconnexion()
    {
        session_destroy();
        header('Location: /?controller=auth&action=connexion');
        exit;
    }
}
