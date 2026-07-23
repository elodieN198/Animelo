<?php

namespace App\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        if (isset($_SESSION['utilisateur_id'])) {
            header('Location: /index.php?controller=post&action=index');
        } else {
            header('Location: /index.php?controller=auth&action=connexion');
        }
        exit;
    }
}