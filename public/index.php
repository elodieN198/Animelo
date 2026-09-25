<?php

/**
 * Point d'entrée unique de l'application.
 *
 * Toutes les requêtes passent par ce fichier : il charge l'autoloader,
 * démarre la session, puis confie la requête au routeur.
 */

require __DIR__ . '/../Autoloader.php';

use App\Autoloader;
use App\Core\Router;

session_start();

Autoloader::register();

$router = new Router();
$router->run();