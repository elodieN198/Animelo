<?php

namespace App\Controllers;

class HomeController extends Controller
{
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