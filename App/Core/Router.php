<?php

namespace App\Core;

/**
 * Dirige chaque requête vers le bon contrôleur et la bonne action.
 *
 * Exemple : /?controller=post&action=profil appelle PostController::profil().
 */
class Router
{
    /**
     * Lit les paramètres controller et action de l'URL, instancie le
     * contrôleur demandé et appelle l'action correspondante.
     * Par défaut, appelle HomeController::index().
     */
    public function run()
    {
        $controllerName = $_GET['controller'] ?? 'Home';
        $actionName = $_GET['action'] ?? 'index';

        $controllerClass = 'App\\Controllers\\' . ucfirst($controllerName) . 'Controller';

        if (!class_exists($controllerClass)) {
            die("Erreur : le contrôleur $controllerClass n'existe pas.");
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $actionName)) {
            die("Erreur : l'action $actionName n'existe pas dans $controllerClass.");
        }

        $controller->$actionName();
    }
}