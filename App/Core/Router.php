<?php

namespace App\Core;

class Router
{
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