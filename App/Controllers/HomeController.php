<?php

namespace App\Controllers;

/**
 * Contrôleur appelé par défaut, quand l'URL ne précise aucun contrôleur.
 */
class HomeController extends Controller
{
    /**
     * Redirige vers le fil d'actualité si l'utilisateur est connecté,
     * sinon vers la page de connexion.
     */
    public function index()
    {
        if (isset($_SESSION['utilisateur_id'])) {
            header('Location: /?controller=post&action=index');
        } else {
            header('Location: /?controller=auth&action=connexion');
        }
        exit;
    }
}